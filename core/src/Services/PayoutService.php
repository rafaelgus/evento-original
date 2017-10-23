<?php
namespace EventoOriginal\Core\Services;

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

        $this->payoutRepository->save($payout);

        return $payout;
    }
}
