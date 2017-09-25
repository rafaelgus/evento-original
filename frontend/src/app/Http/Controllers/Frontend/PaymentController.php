<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Requests\CheckoutRequest;
use EventoOriginal\Core\Enums\PaymentGateway;
use EventoOriginal\Core\Infrastructure\Payments\Checkout\WebCheckout\PaypalService;
use EventoOriginal\Core\Services\ArticleService;
use EventoOriginal\Core\Services\OrderDetailService;
use EventoOriginal\Core\Services\OrderService;
use EventoOriginal\Core\Services\PaymentService;
use Gloudemans\Shoppingcart\Facades\Cart;

class PaymentController
{
    private $orderService;
    private $orderDetailService;
    private $paymentService;
    private $articleService;
    private $paypalService;

    public function __construct(
        OrderService $orderService,
        OrderDetailService $orderDetailService,
        PaymentService $paymentService,
        ArticleService $articleService,
        PaypalService $paypalService
    ) {
        $this->orderDetailService = $orderDetailService;
        $this->paymentService = $paymentService;
        $this->orderService = $orderService;
        $this->articleService = $articleService;
        $this->paypalService = $paypalService;
    }

    public function checkout()
    {
        $items = count($items = Cart::instance('shopping')->content());

        if ($items === 0) {
            abort(400, 'cart empty');
        }
        $cartItems = $this->getSummary();

        return view('frontend.checkout')
            ->with('cartItems', $cartItems);
    }

    public function process(CheckoutRequest $request)
    {
        $user = current_user();


        $details = $this->getDetails();
        $order = $this->orderService->create($details, $user);

        $payment = $this
            ->paymentService
            ->create(
                PaymentGateway::PAYPAL,
                $order
            );
        $this->paypalService->preparePayment($payment);

    }

    public function getDetails()
    {
        $items = Cart::instance('sopping')->content();
        $discounts = Cart::instance('discount')->content();

        $details = [];

        foreach ($items as $item) {
            $article = $this->articleService->findByBarcode($item->id);

            $detail = $this
                ->orderDetailService
                ->create([
                    'quantity' => $item->qty,
                    'article' => $article,
                    'price' => $article->getPrice()
                ]);

            $details[] = $detail;
        }
        foreach ($discounts as $discount) {
            $detail = $this
                ->orderDetailService
                ->create([
                    'quantity' => $discount->qty,
                    'price' => $discount->price
                ], true);

            $details[] = $detail;
        }
        return $details;
    }

    public function getSummary()
    {
        $cart = Cart::instance('shopping')->content();
        $discounts = Cart::instance('discount')->content();

        $itemsAndDiscount = [];

        foreach ($cart as $item) {
            $itemsAndDiscount[] = [
                'id' => $item->rowId,
                'name' => $item->name,
                'qty' => $item->qty,
                'price' => $item->price,
                'image' => $item->options->has('image') ? $item->options->image : '',
                'article' => true
            ];
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
        }
        return $itemsAndDiscount;
    }
}