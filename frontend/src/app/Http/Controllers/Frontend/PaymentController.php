<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Requests\BillingInformationRequest;
use App\Http\Requests\ShippingInformationRequest;
use EventoOriginal\Core\Entities\Voucher;
use EventoOriginal\Core\Enums\PaymentGateway;
use EventoOriginal\Core\Infrastructure\Payments\Checkout\WebCheckout\PaypalService;
use EventoOriginal\Core\Services\AddressService;
use EventoOriginal\Core\Services\ArticleService;
use EventoOriginal\Core\Services\BillingService;
use EventoOriginal\Core\Services\CountryService;
use EventoOriginal\Core\Services\CustomerService;
use EventoOriginal\Core\Services\OrderDetailService;
use EventoOriginal\Core\Services\OrderService;
use EventoOriginal\Core\Services\PaymentService;
use EventoOriginal\Core\Services\ShippingService;
use EventoOriginal\Core\Services\VoucherService;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController
{

    const NEW_ADDRESS_TRUE = 1;
    const NEW_ADDRESS_FALSE = 0;
    const DELIVERY_IN_STORE = 'branch_withdrawal';
    const DELIVERY_HOME = 'home_delivery';

    private $orderService;
    private $orderDetailService;
    private $paymentService;
    private $articleService;
    private $paypalService;
    private $customerService;
    private $countryService;
    private $billingService;
    private $addressService;
    private $shippingService;
    private $voucherService;

    public function __construct(
        OrderService $orderService,
        OrderDetailService $orderDetailService,
        PaymentService $paymentService,
        ArticleService $articleService,
        PaypalService $paypalService,
        CustomerService $customerService,
        CountryService $countryService,
        BillingService $billingService,
        AddressService $addressService,
        ShippingService $shippingService,
        VoucherService $voucherService
    ) {
        $this->orderDetailService = $orderDetailService;
        $this->paymentService = $paymentService;
        $this->orderService = $orderService;
        $this->articleService = $articleService;
        $this->paypalService = $paypalService;
        $this->customerService = $customerService;
        $this->countryService = $countryService;
        $this->billingService = $billingService;
        $this->addressService = $addressService;
        $this->shippingService = $shippingService;
        $this->voucherService = $voucherService;
    }

    public function billingInformation()
    {
        $details = $this->getDetails();
        $user = current_user();
        $customer = $user->getCustomer();

        $order = $this->orderService->create($details, $user);

        $countries = $this->countryService->findAll();

        $addresses = $this->addressService->findByCustomer($customer);

        return view('frontend.checkout.billing')
            ->with('addresses', $addresses)
            ->with('customer', $customer)
            ->with('countries', $countries)
            ->with('orderId', $order->getId());
    }

    public function shippingInformation(BillingInformationRequest $request)
    {
        $customer = current_user()->getCustomer();

        $addresses = $this->addressService->findByCustomer($customer);

        $order = $this->orderService->findById($request->input('orderId'));

        if ($request->input('newAddress') == self::NEW_ADDRESS_TRUE) {
            $countryId = $request->input('country');

            $country = $this->countryService->findById($countryId);

            $address = $this->addressService->create($customer, $country, $request->all());

            $billing = $this->billingService->create($request->all(), $address);
        } else {
            $address = $this->addressService->findById(intval($request->input('addressId')));
            $billing = $this->billingService->create($request->all(), $address);
        }

        return view('frontend.checkout.shipping')
            ->with('billingId', $billing->getId())
            ->with('addresses', $addresses)
            ->with('countries', $this->countryService->findAll())
            ->with('orderId', $order->getId());
    }

    public function checkout(ShippingInformationRequest $request)
    {
        $cartItems = $this->getSummary();
        $user = current_user();

        $order = $this->orderService->findById(intval($request->input('orderId')));

        $customer = $user->getCustomer();

        $billing = $this->billingService->findById($request->input('billingId'));

        if ($request->input('method') === self::DELIVERY_HOME) {
            if ($request->input('newAddress')) {
                $country = $this->countryService->findById($request->input('countryId'));
                $address = $this->addressService->create($customer, $country, $request->all());
            } else {
                $address = $this->addressService->findById($request->input('addressId'));
            }
            $shipping = $this->shippingService->create($address, $request->input('method'));

            $this->orderService->addBilling($order, $billing);
            $this->orderService->addShipping($order, $shipping);
        }
        if ($request->input('method') === self::DELIVERY_IN_STORE) {
            $this->orderService->addBilling($order, $billing);
        }

        $total = 0;

        foreach ($cartItems as $item) {
            $total = $total + ($item['qty'] * $item['price']);
        }

        return view('frontend.checkout.orderView')
            ->with('cartItems', $cartItems)
            ->with('total', $total)
            ->with('order', $order);
    }

    public function process(int $id)
    {
        $order = $this->orderService->findById($id);

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
                return abort(400, 'Error to process payment');
            }
        }
    }

    public function getPaypalCancel(Request $request)
    {
        try {
            if ($request->has('token')) {
                $payment = $this->paymentService->findByToken($request->input('token'));
                $this->paymentService->cancel($payment);

                Cart::instance('shopping')->destroy();
                Cart::instance('discount')->destroy();

                return view('frontend.payment.cancel');
            }
        } catch (Exception $exception) {
            Log::error('PAYPAL '. $exception->getMessage());
            return abort(400, 'Error to process payment');
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

    public function addVoucherInCheckout(Request $request)
    {
        $voucher = $this->voucherService->findByCode($request->input('voucher'));

        if ($voucher) {
            $order = $this->orderService->findById($request->input('orderId'));

            if ($voucher->getType() === VoucherService::TYPE_RELATIVE) {
                $voucherAmount = $order->getTotal() * ($voucher->getValue() / 100);
            } else {
                $voucherAmount = $voucher->getAmount();
            }

            $detail = $this->orderDetailService->create([
                'price' => $voucherAmount,
                'quantity' => 1,
            ], true);

            $order->addOrderDetail($detail);
            $this->orderService->save($order);

            $this->voucherService->useVoucher($voucher->getCode());
            $discount = $this->voucherService->getDiscountAmount($voucher, $order->getTotal());

            Cart::instance('discount')->add(
                $voucher->getCode(),
                'Descuento',
                1,
                $discount
            );

            $cartItems = $this->getSummary();

            return view('frontend.checkout.orderView')
                ->with('cartItems', $cartItems)
                ->with('order', $order);
        } else {
            return abort(400, 'Error voucher not exist');
        }

    }
}