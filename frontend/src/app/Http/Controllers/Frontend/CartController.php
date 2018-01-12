<?php
namespace App\Http\Controllers\Frontend;

use EventoOriginal\Core\Services\ArticleService;
use EventoOriginal\Core\Services\OrderDetailService;
use EventoOriginal\Core\Services\OrderService;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class CartController
{
    private $articleService;
    private $orderDetailService;
    private $orderService;
    private $voucherService;
    private $categoryService;

    public function __construct(
        ArticleService $articleService,
        OrderDetailService $orderDetailService,
        OrderService $orderService
    ) {
        $this->articleService = $articleService;
        $this->orderService = $orderService;
        $this->orderDetailService = $orderDetailService;
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
                'name' => $item->name,
                'qty' => $item->qty,
                'price' => $item->price,
                'image' => $item->options->has('image') ? $item->options->image : '',
                'article' => true
            ];
            $itemTotal = $itemTotal + ($item->price * $item->qty);
        }

        foreach ($discounts as $discount) {
            $itemsAndDiscount[] = [
                'id' => $discount->rowId,
                'name' => $discount->name,
                'qty' => $discount->qty,
                'price' => -$discount->price,
                'image' => $discount->options->has('image') ? $discount->options->image : '',
                'article' => false
            ];

            $discountsTotal = $discountsTotal + $discount->price;
        }

        return view('frontend.shopping_cart')
            ->with('proceedCheckout', $proceedCheckout)
            ->with('cart', $itemsAndDiscount)
            ->with('discounts', $discountsTotal)
            ->with('total', $itemTotal - $discountsTotal);
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

        try {
            $articleImagesPath = $article->getImages()->toArray()[0]->getPath();
        } catch (Exception $exception) {
            $articleImagesPath = '';
        }

        if ($quantity > 0) {
            Cart::instance('shopping')->add(
                $article->getBarCode(),
                $article->getName(),
                $quantity,
                $article->getPrice(),
                [
                    'image' => storage_url() . '/images/' . $articleImagesPath,
                    'category' => $article->getCategory()->getId()
                ]
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

        return ['message' => 'El articulo se modifico la cantidad'];
    }

    public function modifyOrder(int $barCode, int $quantity, bool $discount = false)
    {
        $article = $this->articleService->findByBarcode($barCode);

        $orderDetail = $this->orderDetailService->create([
            'quantity' => $quantity,
            'article' => $article,
            'price' => $article->getPrice()
        ], $discount);

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
}