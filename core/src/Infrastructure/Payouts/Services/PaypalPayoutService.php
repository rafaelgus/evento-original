<?php
namespace EventoOriginal\Core\Infrastructure\Payouts\Services;

use EventoOriginal\Core\Enums\PayoutStatus;
use EventoOriginal\Core\Infrastructure\Payouts\Interfaces\PayoutGatewayInterface;
use EventoOriginal\Core\Infrastructure\Payouts\Interfaces\PayoutInterface;
use Exception;
use PayPal\Rest\ApiContext;

class PaypalPayoutService implements PayoutGatewayInterface
{
    private $apiContext;

    public function __construct(ApiContext $apiContext)
    {
        $this->apiContext = $apiContext;
    }

    public function send(PayoutInterface $payout)
    {
        $payouts = new \PayPal\Api\Payout();

        $senderBatchHeader = new \PayPal\Api\PayoutSenderBatchHeader();

        $senderBatchHeader
            ->setSenderBatchId(uniqid())
            ->setEmailSubject("Nuevo pago de Evento Original")
            ->setRecipientType('EMAIL');

        $senderItem = new \PayPal\Api\PayoutItem();

        $amount = $payout->getOriginalMoney()->getAmount() / 100;
        $currency = $payout->getOriginalMoney()->getCurrency();

        $senderItem->setRecipientType('EMAIL')
            ->setNote('Nuevo pago de Evento Original')
            ->setReceiver($payout->getUser()->getEmail())
            ->setSenderItemId(uniqid())
            ->setAmount(new \PayPal\Api\Currency('{"value":"' . $amount . '","currency":"' . $currency .'"}'));

        $payouts->setSenderBatchHeader($senderBatchHeader)->addItem($senderItem);

        $payout->setRequestData($payouts->toJSON());

        try {
            $output = $payouts->createSynchronous($this->apiContext);

            $payout->setStatus(PayoutStatus::SUCCESS);
            $payout->setResponseData($output);

            logger()->info("Paypal Payout Sent to " . $payout->getReceiver()->getEmail() .
                ": " . $output->getBatchHeader()->getPayoutBatchId());
        } catch (Exception $ex) {
            $payout->setStatus(PayoutStatus::DENIED);
            $payout->setResponseData($ex->getMessage());

            logger()->error("Error sending Paypal Payout to " . $payout->getReceiver()->getEmail() .
                ": " . $ex->getMessage());
        }

        return $payout;
    }
}
