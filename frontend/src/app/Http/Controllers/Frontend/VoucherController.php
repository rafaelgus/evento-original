<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Requests\UseVoucherRequest;
use EventoOriginal\Core\Entities\Voucher;
use EventoOriginal\Core\Services\CategoryService;
use EventoOriginal\Core\Services\OrderDetailService;
use EventoOriginal\Core\Services\OrderService;
use EventoOriginal\Core\Services\VoucherService;
use Exception;
use function foo\func;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class VoucherController
{
    private $voucherService;
    private $categoryService;
    private $orderService;
    private $orderDetailService;

    public function __construct(
        VoucherService $voucherService,
        CategoryService $categoryService,
        OrderService $orderService,
        OrderDetailService $orderDetailService
    ) {
        $this->voucherService = $voucherService;
        $this->categoryService = $categoryService;
        $this->orderService = $orderService;
        $this->orderDetailService = $orderDetailService;
    }

    public function useVoucher(UseVoucherRequest $request)
    {
        try {
            $voucher = $this->voucherService->findByCode($request->input('code'));

            $this->veryfyDiscount($voucher->getCode());

            if ($voucher->getCategory()) {
                $cart = Cart::instance('shopping')->content();

                $totalAmountCategory = 0;

                foreach($cart as $item) {
                    $categoryId = $item->options->category;
                    $category = $this->categoryService->findOneById($categoryId, App::getLocale());

                    $isChildren = $this->categoryService->isChildren($voucher->getCategory(), $category);
                    if ($isChildren) {
                        $totalAmountCategory = $totalAmountCategory + $item->price;
                    }
                }
                if ($totalAmountCategory > 0) {
                    $this->applyDiscount($voucher, $totalAmountCategory);
                } else {
                    throw new Exception();
                }
            } else {
                $this->applyDiscount($voucher);
            }

            return response('voucher added', 200);
        } catch (Exception $exception) {
            throw  $exception;
            return response('voucher en uso o incorrecto',400);
        }
    }

    private function applyDiscount(Voucher $voucher, $total = null)
    {
        if (!$total) {
            $items = Cart::instance('shopping')->content();
            $total = 0;

            foreach ($items as $item) {
                $total = $total + ($item->price * $item->qty);
            }
        }

        $discount = $this->voucherService->getDiscountAmount($voucher, $total);

        Cart::instance('discount')->add(
            $voucher->getCode(),
            'Descuento',
            1,
            $discount
        );

        $this->addDiscountToOrder($discount);
    }

    public function addDiscountToOrder(int $discount)
    {
        $orderDetail = $this->orderDetailService->create([
            'price' => $discount,
            'quantity' => 1
        ], true);

        $orderId = Session::get('orderId');

        if ($orderId) {
            $order = $this->orderService->findById($orderId);

            $this->orderDetailService->setOrder([$orderDetail], $order);

            $order->addOrderDetail($orderDetail);
            $this->orderService->save($order);
        } else {
            throw new Exception('Imposible to add discount');
        }
    }

    /**
     * @param string $code
     */
    public function veryfyDiscount(string $code)
    {
        $cartItmes = Cart::instance('discount')->content();

        foreach ($cartItmes as $item) {
            if ($item->id == $code) {
                throw new Exception();
            }
        }
    }
}