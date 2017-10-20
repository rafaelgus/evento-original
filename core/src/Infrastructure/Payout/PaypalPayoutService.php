<?php

namespace EventoOriginal\Core\Infrastructure\Payout;

use EventoOriginal\Core\Entities\Payout;
use Exception;
use PayPal\Rest\ApiContext;
use PHPUnit\TextUI\ResultPrinter;

class PaypalPayoutService
{
    private $apiContext;

    public function __construct(ApiContext $apiContext)
    {
        $this->apiContext = $apiContext;
    }


    public function prepare(Payout $payout)
    {
        $payouts = new \PayPal\Api\Payout();

        $senderBatchHeader = new \PayPal\Api\PayoutSenderBatchHeader();

        $senderBatchHeader->setSenderBatchId(uniqid())
            ->setEmailSubject("Nuevo pago de Evento Original");

        $senderItem = new \PayPal\Api\PayoutItem();

        $amount = $payout->getOriginalAmount() / 100;

        $senderItem->setRecipientType('Email')
            ->setNote('Nuevo pago mensual')
            ->setReceiver($payout->getUser()->getEmail())
            ->setSenderItemId(uniqid())
            ->setAmount(new \PayPal\Api\Currency('{
                                "value":"1.00",
                                "currency":"EUR"
                            }'));

        $payouts->setSenderBatchHeader($senderBatchHeader)
            ->addItem($senderItem);

        try {
            $output = $payouts->createSynchronous($this->apiContext);

            logger()->info("Paypal Payout Sent: " .$output->getBatchHeader()->getPayoutBatchId());

            return $output;
        } catch (Exception $ex) {
            logger()->error("Paypal Payout error: " . $ex->getMessage());

            throw $ex;
        }
    }
}
