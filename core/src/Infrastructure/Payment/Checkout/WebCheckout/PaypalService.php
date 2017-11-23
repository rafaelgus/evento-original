<?php
namespace EventoOriginal\Core\Infrastructure\Payments\Checkout\WebCheckout;

use EventoOriginal\Core\Entities\Payment;
use EventoOriginal\Core\Enums\PaymentGateway;
use EventoOriginal\Core\Enums\PaymentStatus;
use EventoOriginal\Core\Infrastructure\Payments\Exceptions\InvalidGatewayException;
use EventoOriginal\Core\Infrastructure\Payments\Exceptions\InvalidPaymentStatusException;
use EventoOriginal\Core\Infrastructure\Payments\Exceptions\PaypalGatewayException;
use EventoOriginal\Core\Infrastructure\Payments\Interfaces\PaymentGatewayInterface;
use EventoOriginal\Core\Services\PaymentService;
use Exception;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\Payment as PaypalPayment;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;

class PaypalService implements PaymentGatewayInterface
{
    const CURRENCY_USD = 'USD';
    const CURRENCY_EUR = 'EUR';
    const METHOD = 'paypal';
    const URL_ACCEPT = 'http://localhost/paypalConfirm';
    const URL_CANCEL = 'http://localhost/paypalCancel';

    const PAYMENT_STATE_APPROVED = 'approved';
    const RESOURCE_STATE_COMPLETED = 'completed';

    protected $acceptedCurrencies = [
        self::CURRENCY_EUR,
        self::CURRENCY_USD
    ];

    protected $apiContext;
    protected $config;
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $paypalConfig = require 'PaypalConfig.php';
        $this->config = $paypalConfig['paypal'];
        $this->paymentService = $paymentService;
    }

    /**
     * Prepare a payment to checkout
     *
     * @param Payment $payment
     * @param array $params
     * @return Payment
     * @throws Exception
     */
    public function preparePayment(Payment $payment, array $params = [])
    {
        if ($payment->getOriginalMoney()->isZero()) {
            throw new Exception('The amount cannot zero');
        }
        if ($payment->getStatus() ==! PaymentStatus::STATUS_CREATED) {
            throw new Exception('invalid state of payment');
        }
        $payment->setPaidMoney($payment->getOriginalMoney());
        $payer = new Payer();
        $payer->setPaymentMethod(self::METHOD);

        $item = new Item();
        $item->setDescription($payment->getDescription());
        $item->setCurrency(self::CURRENCY_EUR);
        $item->setQuantity(1);
        $item->setPrice($payment->getPaidMoney()->getAmount());
        $item->setName('payment');
        $item->setSku('sku');

        $itemList = new ItemList();
        $itemList->setItems([$item]);

        $details = new Details();
        $details->setSubtotal($payment->getPaidMoney()->getAmount());

        $amount = new Amount();
        $amount->setCurrency(self::CURRENCY_EUR);
        $amount->setTotal($payment->getPaidMoney()->getAmount());
        $amount->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setItemList($itemList);
        $transaction->setDescription($payment->getDescription());

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(self::URL_ACCEPT);
        $redirectUrls->setCancelUrl(self::URL_CANCEL);

        $paypalPayment = new PaypalPayment();
        $paypalPayment->setPayer($payer);
        $paypalPayment->setRedirectUrls($redirectUrls);
        $paypalPayment->setTransactions([$transaction]);
        $paypalPayment->setIntent('sale');

        try {
            $paypalPayment->create($this->apiContext());
        } catch (PayPalConnectionException $exception) {
            throw $exception;
        } catch (Exception $exception) {
            logger()->error($exception->getMessage());
            throw new Exception('Error at prepare payment');
        }

        foreach ($paypalPayment->getLinks() as $link) {
            if ($link->getRel() === 'approval_url') {
                $redirectUrl = $link->getHref();
                break;
            }
        }

        if (isset($redirectUrl)) {
            $token = $this->token($redirectUrl);
            $payment->setExternalId($token);
            $payment->setParam('redirectUrl', $redirectUrl);
            $payment->setParam('paypalId', $paypalPayment->getId());
            $payment->setData(json_decode($paypalPayment->toJson(), true));
            $payment->setStatus(PaymentStatus::STATUS_PENDING);
        }
        return $payment;
    }
    /**
     * Process a payment
     *
     * @param Payment $payment
     * @param array $params
     * @return Payment
     * @throws Exception
     */
    public function processPayment(Payment $payment, array $params)
    {
        $params += [
            'payerId' => null
        ];
        $paypalId = $payment->getParam('paypalId');

        if (empty($paypalId)) {
            throw new Exception('Missing Paypal Id');
        }
        $payerId = $params['payerId'];

        if (empty($payerId)) {
            throw new PaypalGatewayException('Missing Payer Id');
        }

        if (!$payment->getStatus() === PaymentStatus::STATUS_PENDING) {
            throw new Exception('Only can process a payment with pending status');
        }

        $paypalPayment = $this->getPaypalPayment($paypalId);
        if ($this->isApproved($paypalPayment)) {
            return json_decode($paypalPayment->toJson(), true);
        }
        $paypalPayment = $this->executePayment($paypalPayment, $payerId);
        if (!$this->isApproved($paypalPayment)) {
            throw new PaypalGatewayException('Paypal payment is not approved');
        }
        $data = json_decode($paypalPayment->toJson(), true);
        $payment->setData($data);
        $payment = $this->paymentService->pay($payment);
        return $payment;
    }

    /**
     * Changing a payment status to "pending"
     *
     * @param Payment $payment
     * @param array $params
     * @throws Exception
     */
    public function pendingPayment(Payment $payment, array $params)
    {
        if (!$payment->getStatus() === PaymentStatus::STATUS_PENDING) {
            throw new InvalidPaymentStatusException();
        }
    }

    /**
     * Changing a payment status to "canceled"
     *
     * @param Payment $payment
     * @param array $params
     * @throws Exception
     */
    public function canceledPayment(Payment $payment, array $params)
    {
        if (!$payment->getStatus() === PaymentStatus::STATUS_PENDING    ) {
            throw new InvalidPaymentStatusException('Only can cancel a payment with pending status');
        }
        $this->paymentService->cancel($payment);
    }

    public function apiContext()
    {
        if (empty($this->apiContext)) {
            $apiContext = new ApiContext(
                new OAuthTokenCredential(
                    $this->config['client_id'],
                    $this->config['client_secret']
                )
            );
            $apiContext->setConfig([
                'mode' => 'sandbox',
                'log.LogEnabled'   => true,
                'log.FileName'     => '../PayPal.log',
                'log.LogLevel'     => 'DEBUG'
            ]);
            $this->apiContext = $apiContext;
        }
        return $this->apiContext;
    }

    public function getPaypalPayment(string $paypalId)
    {
        $apiContext = $this->apiContext();
        return PaypalPayment::get($paypalId, $apiContext);
    }

    /**
     * @param PaypalPayment $payment
     * @param $payerId
     * @return PaypalPayment
     */
    public function executePayment(PaypalPayment $payment, $payerId)
    {
        $apiContext = $this->apiContext();
        $paymentExecution = new PaymentExecution();
        $paymentExecution->setPayerId($payerId);
        return $payment->execute($paymentExecution, $apiContext);
    }

    private function token(string $url)
    {
        $urlComponents = parse_url($url);
        $queryString = $urlComponents['query'];
        $queryParams = [];

        parse_str($queryString, $queryParams);

        return $queryParams['token'];
    }

    private function isApproved(PaypalPayment $payment)
    {
        return $payment->getState() !== static::PAYMENT_STATE_APPROVED ? false : true;
    }
}