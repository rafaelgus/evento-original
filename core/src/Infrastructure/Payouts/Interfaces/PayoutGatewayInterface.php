<?php

namespace EventoOriginal\Core\Infrastructure\Payouts\Interfaces;

interface PayoutGatewayInterface
{
    /**
     * Send a payout
     *
     * @param PayoutInterface $payout
     * @return PayoutInterface
     */
    public function send(PayoutInterface $payout);

    /**
     * Process webhook notification
     *
     * @param PayoutInterface $payout
     * @param array $data
     * @return PayoutInterface
     */
    public function processWebhook(PayoutInterface $payout, array $data);
}
