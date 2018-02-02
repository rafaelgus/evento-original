<?php
namespace EventoOriginal\Core\Infrastructure\Payments\Interfaces;

use EventoOriginal\Core\Entities\Payment;

interface PaymentGatewayInterface
{
    /**
     * Prepare a payment to checkout
     *
     * @param Payment $payment
     * @param array $params
     * @return Payment
     */
    public function preparePayment(Payment $payment, array $params);
    /**
     * Process a payment
     *
     * @param Payment $payment
     * @param array $params
     * @return Payment
     */
    public function processPayment(Payment $payment, array $params);
    /**
     * Changing a payment status to "pending"
     *
     * @param Payment $payment
     * @param array $params
     */
    public function pendingPayment(Payment $payment, array $params);
    /**
     * Changing a payment status to "canceled"
     *
     * @param Payment $payment
     * @param array $params
     */
    public function canceledPayment(Payment $payment, array $params);
}