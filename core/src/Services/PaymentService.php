<?php
namespace EventoOriginal\Core\Services;

use DateTime;
use EventoOriginal\Core\Entities\Order;
use EventoOriginal\Core\Entities\Payment;
use EventoOriginal\Core\Enums\OrderStatus;
use EventoOriginal\Core\Enums\PaymentGateway;
use EventoOriginal\Core\Enums\PaymentStatus;
use EventoOriginal\Core\Infrastructure\Payments\Exceptions\InvalidGatewayException;
use EventoOriginal\Core\Infrastructure\Payments\Exceptions\InvalidPaymentStatusException;
use EventoOriginal\Core\Infrastructure\Payments\PaymentGatewayFactory;
use EventoOriginal\Core\Persistence\Repositories\PaymentRepository;
use Exception;

class PaymentService
{
    protected $paymentRepository;
    protected $paymentGateway;

    public function __construct(PaymentRepository $paymentRepository, PaymentGatewayFactory $paymentGatewayFactory)
    {
        $this->paymentRepository = $paymentRepository;
        $this->paymentGateway = $paymentGatewayFactory;
    }

    protected $acceptedGateway = [
        PaymentGateway::PAYPAL
    ];

    public function acceptedGateways()
    {
        return $this->acceptedGateway;
    }

    /**
     * @param string $gateway
     * @param Order $order
     * @throws Exception
     * @return Payment
     */
    public function create(string $gateway, Order $order)
    {
        if (!in_array($gateway, $this->acceptedGateways())) {
            throw new Exception('Invalid gateway');
        }
        $payment = new Payment();
        $payment->setGateway($gateway);
        $payment->setOriginalMoney($order->getTotal());
        $payment->setPayer($order->getUser());
        $payment->setStatus(PaymentStatus::STATUS_CREATED);
        $payment->setOrder($order);

        $this->paymentRepository->save($payment);

        return $payment;
    }

    public function prepare(Order $order, array $data)
    {
        if (!array_has($data, 'gateway')) {
            throw new InvalidGatewayException();
        }
        if (!$order->getStatus() != OrderStatus::STATUS_PENDING) {
            throw new Exception('Invalid order');
        }
        $payment = $this->create($data['gateway'], $order);
        if ($payment->getOriginalMoney()->isZero()) {
            $payment->setStatus(PaymentStatus::STATUS_PENDING);
            $this->pay($payment);
            return $payment;
        }
        $paymentMethod = $this->paymentGateway->create($data['gateway']);
        $paymentMethod->prepare($payment, $data);
        try {
            $payment = $paymentMethod->process($payment, $data);
        } catch (Exception $exception) {
            $payment->setStatus(PaymentStatus::STATUS_CANCELED);
            $payment = $this->cancel($payment);
        }
        if ($payment->getStatus() === PaymentStatus::STATUS_PAYMENT_APPROVE) {
            $payment->setStatus(PaymentStatus::STATUS_PENDING);
            $payment = $this->pay($payment);
        }
        if ($payment->getStatus() === PaymentStatus::STATUS_CANCELED) {
            $payment = $this->cancel($payment);
        }
        $this->paymentRepository->save($payment);
    }

    /**
     * @param Payment $payment
     * @return Payment $payment
     * @throws InvalidPaymentStatusException
     */
    public function pay(Payment $payment)
    {
        if ($payment->getStatus() != PaymentStatus::STATUS_PENDING) {
            throw new InvalidPaymentStatusException();
        }
        $payment->setPaidDate(new DateTime());
        $payment->setStatus(PaymentStatus::STATUS_PAYMENT_APPROVE);
        $payment->getOrder()->setStatus(OrderStatus::STATUS_PAYMENT_APPROVE);

        $this->paymentRepository->save($payment);
        return $payment;
    }

    /**
     * @param Payment $payment
     * @return Payment $payment
     * @throws InvalidPaymentStatusException
     */
    public function cancel(Payment $payment)
    {
        if ($payment->getStatus() === PaymentStatus::STATUS_PAID) {
            throw new InvalidPaymentStatusException();
        }
        $payment->setStatus(PaymentStatus::STATUS_CANCELED);
        $this->paymentRepository->save($payment);
        return $payment;
    }

    public function save(Payment $payment)
    {
        $this->paymentRepository->save($payment);
    }

    public function findByToken(string $token)
    {
        return $this->paymentRepository->findByToken($token);
    }
}