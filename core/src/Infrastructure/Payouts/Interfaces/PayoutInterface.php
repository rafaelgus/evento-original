<?php
namespace EventoOriginal\Core\Infrastructure\Payouts\Interfaces;

use EventoOriginal\Core\Entities\User;
use Money\Money;

interface PayoutInterface
{
    /**
     * Get payout identifier
     *
     * @return int
     */
    public function getId();

    /**
     * Get description payout
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get receiver of the payout
     *
     * @return ReceiverInterface
     */
    public function getReceiver();

    /**
     * Set receiver of the payout
     *
     * @param User $receiver
     */
    public function setReceiver(User $receiver);

    /**
     * Get payout gateway
     *
     * @return string
     */
    public function getGateway();

    /**
     * Set payout gateway
     *
     * @param $gateway
     */
    public function setGateway(string $gateway);

    /**
     * Get payout status
     *
     * @return string
     */
    public function getStatus();

    /**
     * Set payout status
     *
     * @param string $status
     */
    public function setStatus(string $status);

    /**
     * Get original money of the payout
     *
     * @return Money
     */
    public function getOriginalMoney();

    /**
     * Set original money of the payout
     *
     * @param Money $money
     */
    public function setOriginalMoney(Money $money);

    /**
     * Get data to request the payout
     *
     * @return string
     */
    public function getRequestData();

    /**
     * Set data to request the payout
     *
     * @param string $data
     */
    public function setRequestData(string $data);

    /**
     * Get response data of the payout
     *
     * @return string
     */
    public function getResponseData();

    /**
     * Set response data of the payout
     *
     * @param string $data
     */
    public function setResponseData(string $data);

    /**
     * @return string
     */
    public function getExternalId();

    /**
     * @param string $externalId
     */
    public function setExternalId(string $externalId);
}

