<?php
namespace EventoOriginal\Core\Infrastructure\Payments\Interfaces;

use Money\Money;

interface PaymentInterface
{
    /**
     * Get payment identifier
     *
     * @return int
     */
    public function getId();
    /**
     * Get payer of the payment
     *
     * @return PayerInterface
     */
    public function getPayer();
    /**
     * Set payer of the payment
     *
     * @param PayerInterface $payer
     */
    public function setPayer(PayerInterface $payer);
    /**
     * Get payment gateway
     *
     * @return string
     */
    public function getGateway();
    /**
     * Set payment gateway
     *
     * @param string $gateway
     */
    public function setGateway(string $gateway);
    /**
     * Get payment status
     *
     * @return string
     */
    public function getStatus();
    /**
     * Set payment status
     *
     * @param string $status
     */
    public function setStatus(string $status);
    /**
     * Get original money of the payment
     *
     * @return Money
     */
    public function getOriginalMoney();
    /**
     * Set original money of the payment
     *
     * @param Money $money
     */
    public function setOriginalMoney(Money $money);
    /**
     * Get paid money of the payment
     *
     * @return Money
     */
    public function getPaidMoney();
    /**
     * Set paid money of the payment
     *
     * @param Money $money
     */
    public function setPaidMoney(Money $money);
    /**
     * Get data to request the payment
     *
     * @return array
     */
    public function getRequestData();
    /**
     * Set data to request the payment
     *
     * @param array $data
     */
    public function setRequestData(array $data);
    /**
     * Get response data of the payment
     *
     * @return array
     */
    public function getResponseData();
    /**
     * Set response data of the payment
     *
     * @param array $data
     */
    public function setResponseData(array $data);
}