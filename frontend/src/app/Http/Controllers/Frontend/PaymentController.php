<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Requests\CheckoutRequest;
use EventoOriginal\Core\Enums\PaymentGateway;
use EventoOriginal\Core\Infrastructure\Payments\Checkout\WebCheckout\PaypalService;
use EventoOriginal\Core\Services\ArticleService;
use EventoOriginal\Core\Services\CustomerService;
use EventoOriginal\Core\Services\OrderDetailService;
use EventoOriginal\Core\Services\OrderService;
use EventoOriginal\Core\Services\PaymentService;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController
{
    private $orderService;
    private $orderDetailService;
    private $paymentService;
    private $articleService;
    private $paypalService;
    private $customerService;

    public function __construct(
        OrderService $orderService,
        OrderDetailService $orderDetailService,
        PaymentService $paymentService,
        ArticleService $articleService,
        PaypalService $paypalService,
        CustomerService $customerService
    ) {
        $this->orderDetailService = $orderDetailService;
        $this->paymentService = $paymentService;
        $this->orderService = $orderService;
        $this->articleService = $articleService;
        $this->paypalService = $paypalService;
        $this->customerService = $customerService;
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
        $customer = $user->getCustomer();

        $this->customerService->updateCheckoutInformation($customer, $request->all());

        $details = $this->getDetails();

        $order = $this->orderService->create($details, $user);

        $payment = $this
            ->paymentService
            ->create(
                PaymentGateway::PAYPAL,
                $order
            );

        $payment = $this->paypalService->preparePayment($payment);
        $this->paymentService->save($payment);

        if ($payment->getGateway() === PaymentGateway::PAYPAL) {
            return redirect()->to($payment->getParam('redirectUrl'));
        } else {
            return abort(400, 'Invalid method');
        }
    }

    public function getPaypalConfirm(Request $request)
    {
        if ($request->has('token')) {
            try {
                $payment = $this->paymentService->findByToken($request->input('token'));

                $data['payerId'] = $request->input('PayerID');
                $this->paypalService->processPayment($payment, $data);

                Cart::instance('shopping')->destroy();
                Cart::instance('discount')->destroy();

                return view('frontend.payment.success');

            } catch (Exception $exception) {
                Log::error('PAYPAL '. $exception->getMessage());
                dd($exception->getMessage());
                return abort(400, 'Error to process payment');
            }
        }
    }

    public function getDetails()
    {
        $items = Cart::instance('shopping')->content();
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