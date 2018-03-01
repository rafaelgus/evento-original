<?php
namespace App\Http\Controllers\Frontend;

use EventoOriginal\Core\Entities\CircularDesignVariantDetail;
use EventoOriginal\Core\Entities\Design;
use EventoOriginal\Core\Persistence\Repositories\CircularDesignVariantDetailRepository;
use EventoOriginal\Core\Persistence\Repositories\VisitorEventRepository;
use EventoOriginal\Core\Services\ArticleService;
use EventoOriginal\Core\Services\OrderDetailService;
use EventoOriginal\Core\Services\OrderService;
use EventoOriginal\Core\Services\VoucherService;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Money\Currency;
use Money\Money;

class CartController
{
    const CURRENCY_EUR = 'EUR';

    private $articleService;
    private $orderDetailService;
    private $orderService;
    private $voucherService;
    /**
     * @var VisitorEventRepository
     */
    private $visitorEventRepository;
    /**
     * @var CircularDesignVariantDetailRepository
     */
    private $circularDesignVariantDetailRepository;

    public function __construct(
        ArticleService $articleService,
        OrderDetailService $orderDetailService,
        OrderService $orderService,
        VoucherService $voucherService,
        VisitorEventRepository $visitorEventRepository,
        CircularDesignVariantDetailRepository $circularDesignVariantDetailRepository
    ) {
        $this->articleService = $articleService;
        $this->orderService = $orderService;
        $this->orderDetailService = $orderDetailService;
        $this->voucherService = $voucherService;
        $this->visitorEventRepository = $visitorEventRepository;
        $this->circularDesignVariantDetailRepository = $circularDesignVariantDetailRepository;
    }

    public function show()
    {
        $cart = Cart::instance('shopping')->content();
        $discounts = Cart::instance('discount')->content();

        $itemsAndDiscount = [];
        $itemTotal = 0;
        $discountsTotal = 0;

        $proceedCheckout = count($cart) > 0 ? true : false;

        foreach ($cart as $item) {
            $itemsAndDiscount[] = [
                'id' => $item->rowId,
                'barCode' => $item->id,
                'name' => $item->name,
                'qty' => $item->qty,
                'price' => $item->price,
                'image' => $item->options->has('image') ? $item->options->image : '',
                'currency' => $item->options->has('currency') ? $item->options->currency : '',
                'article' => true,
                'variantDetail' => $item->options->has('variantDetail') ? $item->options->variantDetail : null,
            ];
            $itemTotal = $itemTotal + ($item->price * $item->qty);
        }

        foreach ($discounts as $discount) {
            $voucher = $this->voucherService->findByCode($discount->id);

            $discountAmount = $this->voucherService->getDiscountAmount($voucher, $itemTotal);

            Cart::instance('discount')->update($discount->rowId, ['price' => $discountAmount->getAmount()]);

            $itemsAndDiscount[] = [
                'id' => $discount->rowId,
                'name' => $discount->name,
                'qty' => $discount->qty,
                'price' => -$discount->price,
                'image' => $discount->options->has('image') ? $discount->options->image : '',
                'currency' => $discount->options->has('currency') ? $discount->options->currency : '',
                'article' => false,
            ];

            $discountsTotal = $discountsTotal + $discountAmount->getAmount();
        }

        $total = $itemTotal - $discountsTotal;

        if ($total < 0) {
            $total = 0;
        }

        $totalMoney = new Money($total, new Currency(self::CURRENCY_EUR));
        $discountMoney = new Money($discountsTotal, new Currency(self::CURRENCY_EUR));

        return view('frontend.shopping_cart')
            ->with('proceedCheckout', $proceedCheckout)
            ->with('cart', $itemsAndDiscount)
            ->with('discounts', $discountMoney)
            ->with('total', $totalMoney);
    }

    public function addToCart(Request $request)
    {
        $quantity = $request->input('quantity');
        $article = $this
            ->articleService
            ->findOneById(
                $request->input('articleId'),
                App::getLocale()
            );

        if ($article->getImages()->count() > 0) {
            $articleImagesPath = $article->getImages()->toArray()[0]->getPath();
            $image = $articleImagesPath;
        } else {
            $image = default_article_image_path();
        }

        $price = $article->getPrice();

        $design = $article->getDesign();

        $variantDetail = $this->getVariantDesign($design);
        if ($variantDetail) {
            $costPrice = $variantDetail->getBasePrice();
            $price = $costPrice + ($costPrice * ($design->getCommission() / 100));
        }

        if ($quantity > 0) {
            $itemData = [
                'image' => $image,
                'category' => $article->getCategory()->getId(),
                'currency' => $article->getMoneyPrice()->getCurrency()->getCode()
            ];

            if ($variantDetail) {
                $itemData['variantDetail'] = $variantDetail->getId();
            }

            Cart::instance('shopping')->add(
                $article->getBarCode(),
                $article->getName(),
                $quantity,
                $price,
                $itemData
            );

            $this->modifyOrder($article->getBarCode(), $quantity);
        }

        return [
            'message' => trans('frontend/shopping_cart.add_to_cart'),
        ];
    }

    public function removeToCart(string $rowId)
    {
        Cart::instance('shopping')->remove($rowId);

        return redirect()->to(trans('frontend/shopping_cart.slug'));
    }

    public function getItemQuantity()
    {
        $quantity = Cart::instance('shopping')->count();

        return ['itemQuantity' => $quantity];
    }

    public function destroyCart()
    {
        Cart::instance('shopping')->destroy();
        Cart::instance('discount')->destroy();

        Session::put('orderId', null);

        return redirect()->to(trans('frontend/shopping_cart.slug'));
    }

    public function updateQuantity(Request $request)
    {
        Cart::instance('shopping')->update($request->input('rowId'), $request->input('qty'));

        $item = Cart::instance('shopping')->get($request->input('rowId'));

        $this->updateOrderDetailQuantity($item->id, $request->input('qty'));

        return ['message' => 'El articulo se modifico la cantidad'];
    }

    public function modifyOrder(string $barCode, int $quantity, bool $discount = false)
    {
        $article = $this->articleService->findByBarcode($barCode);

        $data = [
            'quantity' => $quantity,
            'article' => $article,
            'price' => $article->getPrice()
        ];

        $design = $article->getDesign();

        $variantDetail = $this->getVariantDesign($design);
        if ($variantDetail) {
            $costPrice = $variantDetail->getBasePrice();
            $price = $costPrice + ($costPrice * ($design->getCommission() / 100));

            $data['price'] = $price;
            $data['circularDesignVariantDetail'] = $variantDetail;
        }

        $orderDetail = $this->orderDetailService->create($data, $discount);

        $orderId = Session::get('orderId');

        if ($orderId) {
            $order = $this->orderService->findById($orderId);

            if (!$order) {
                throw new Exception('Error to add item');
            }
            $order->addOrderDetail($orderDetail);

            $this->orderService->save($order);
        } else {
            $order = $this->orderService->create(
                [$orderDetail],
                current_user()
            );
            Session::put('orderId', $order->getId());
        }
    }

    public function updateOrderDetailQuantity(string $code, int $qty)
    {
        $orderId = Session::get('orderId');

        $order = $this->orderService->findById($orderId);

        $orderDetails = $order->getOrdersDetail();

        foreach ($orderDetails as $orderDetail) {
            if ($orderDetail->getArticle()->getBarCode() == $code) {
                $this->orderDetailService->updateQty($orderDetail, $qty);
            }
        }
    }

    public function updateVariantDetail(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->input('rowId'));

        $variantDetailId = $request->input('variantDetail');

        $options = $item->options;
        $options['variantDetail'] = $variantDetailId;

        $variantDetail = $this->circularDesignVariantDetailRepository->findOneById($variantDetailId);

        $article = $this->articleService->findByBarcode($item->id);

        $design = $article->getDesign();

        $price = $variantDetail->getPriceWithCommissionMoney($design->getCommission());

        Cart::instance('shopping')->update(
            $request->input('rowId'),
            [
                'options' => $options,
                'price' => $price->getAmount(),
            ]
        );

        $this->updateOrderDetailVariantDetail($item->id, $variantDetail, $price->getAmount());

        return ['message' => 'Al articulo se le modifico la variante'];
    }

    public function updateOrderDetailVariantDetail(
        string $code,
        CircularDesignVariantDetail $variantDetail,
        int $price
    ) {
        $orderId = Session::get('orderId');

        $order = $this->orderService->findById($orderId);

        $orderDetails = $order->getOrdersDetail();

        foreach ($orderDetails as $orderDetail) {
            if ($orderDetail->getArticle()->getBarCode() == $code) {
                $this->orderDetailService->updateVariantDetail($orderDetail, $variantDetail, $price);
            }
        }
    }

    private function getVariantDesign(?Design $design)
    {
        if ($design && $design->getCircularDesignVariant()) {
            $variant = $design->getCircularDesignVariant();

            return $variant->getDefaultDetail();
        }

        return null;
    }
}
