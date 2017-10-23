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
}
