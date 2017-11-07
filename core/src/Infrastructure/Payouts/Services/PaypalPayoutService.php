<?php
namespace EventoOriginal\Core\Infrastructure\Payouts\Services;

use EventoOriginal\Core\Enums\PayoutStatus;
use EventoOriginal\Core\Infrastructure\Payouts\Enums\PaypalPayoutStatus;
use EventoOriginal\Core\Infrastructure\Payouts\Interfaces\PayoutGatewayInterface;
use EventoOriginal\Core\Infrastructure\Payouts\Interfaces\PayoutInterface;
use Exception;
use PayPal\Api\PayoutItem;
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

        $externalId = uniqid();
        $payout->setExternalId($externalId);

        $senderItem->setRecipientType('EMAIL')
            ->setNote('Nuevo pago de Evento Original')
            ->setReceiver($payout->getUser()->getEmail())
            ->setSenderItemId($externalId)
            ->setAmount(new \PayPal\Api\Currency('{"value":"' . $amount . '","currency":"' . $currency .'"}'));

        $payouts->setSenderBatchHeader($senderBatchHeader)->addItem($senderItem);

        $payout->setRequestData($payouts->toJSON());

        try {
            $output = $payouts->create(null, $this->apiContext);

            logger()->info($output);

            $payout->setStatus(PayoutStatus::PENDING);
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

    public function processWebhook(PayoutInterface $payout, array $data)
    {
        $paypalPayoutItem = PayoutItem::get($data['resource']['payout_item_id'], $this->apiContext);

        $payout->setStatus(strtolower($paypalPayoutItem->getTransactionStatus()));
        $payout->setResponseData($paypalPayoutItem->toJSON());
        
        return $payout;
    }
}
