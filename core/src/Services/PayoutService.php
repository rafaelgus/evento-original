<?php

namespace EventoOriginal\Core\Services;

use App\Events\PayoutRefunded;
use DateTime;
use EventoOriginal\Core\Entities\Payout;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Enums\PayoutGateways;
use EventoOriginal\Core\Enums\PayoutStatus;
use EventoOriginal\Core\Infrastructure\Payouts\PayoutGatewayFactory;
use EventoOriginal\Core\Persistence\Repositories\PayoutRepository;
use Exception;

class PayoutService
{
    private $payoutRepository;
    private $payoutGatewayFactory;

    public static $statusToRefund = [
        PayoutStatus::DENIED,
        PayoutStatus::BLOCKED,
        PayoutStatus::FAILED,
        PayoutStatus::REFUNDED,
        PayoutStatus::RETURNED,
        PayoutStatus::REVERSED,
    ];

    public function __construct(
        PayoutRepository $payoutRepository,
        PayoutGatewayFactory $payoutGatewayFactory
    ) {
        $this->payoutRepository = $payoutRepository;
        $this->payoutGatewayFactory = $payoutGatewayFactory;
    }

    public $acceptedGateways = [
        PayoutGateways::PAYPAL
    ];

    public function create(User $user, string $gateway, $amount)
    {
        if (!in_array($gateway, $this->acceptedGateways)) {
            throw new Exception('Invalid gateway');
        }

        $payout = new Payout();
        $payout->setUser($user);
        $payout->setDate(new DateTime());
        $payout->setDescription("Payout of wallet balance");
        $payout->setGateway($gateway);
        $payout->setStatus(PayoutStatus::PENDING);
        $payout->setOriginalAmount($amount);
        $payout->setOriginalCurrency('EUR');

        $this->payoutRepository->save($payout);

        return $payout;
    }

    public function send(Payout $payout)
    {
        if ($payout->getStatus() !== PayoutStatus::PENDING) {
            throw new Exception("Invalid payout status to send");
        }

        $payout->setStatus(PayoutStatus::PROCESSING);
        $this->payoutRepository->save($payout);

        try {
            $payout = $this->payoutGatewayFactory->create($payout->getGateway())
                ->send($payout);
        } catch (Exception $exception) {
            logger()->error($exception->getMessage());
        }

        if ($this->haveToRefundPayout($payout)) {
            $payout->setStatus(PayoutStatus::REFUNDED);

            event(new PayoutRefunded($payout));
        }

        $this->payoutRepository->save($payout);

        return $payout;
    }

    public function processWebhook(Payout $payout, array $data)
    {
        try {
            $payout = $this->payoutGatewayFactory->create($payout->getGateway())
                ->processWebhook($payout, $data);

            if ($this->haveToRefundPayout($payout)) {
                $payout->setStatus(PayoutStatus::REFUNDED);

                event(new PayoutRefunded($payout));
            }

            $this->payoutRepository->save($payout);
        } catch (Exception $exception) {
            logger()->error($exception->getMessage());

            throw $exception;
        }

        $this->payoutRepository->save($payout);

        return $payout;
    }

    private function haveToRefundPayout(Payout $payout)
    {
        $haveToRefund = false;

        if (in_array($payout->getStatus(), self::$statusToRefund)) {
            $haveToRefund = true;
        }

        return $haveToRefund;
    }

    public function findByExternalId(string $externalId): ?Payout
    {
        return $this->payoutRepository->findByExternalId($externalId);
    }

    public function getAllByUser(User $user)
    {
        return $this->payoutRepository->findByUser($user);
    }

    public function getAllByUserPaginated(User $user, int $currentPage = 1, int $maxItems = 10)
    {
        return $this->payoutRepository->findAllByUserPaginated($user, $currentPage, $maxItems);
    }

    public function getAllPaginated(int $currentPage = 1, int $maxItems = 10)
    {
        return $this->payoutRepository->findAllPaginated($currentPage, $maxItems);
    }
}
