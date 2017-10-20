<?php
namespace EventoOriginal\Core\Services;

use DateTime;
use EventoOriginal\Core\Entities\Payout;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Enums\PayoutGateways;
use EventoOriginal\Core\Enums\PayoutStatus;
use EventoOriginal\Core\Persistence\Repositories\PayoutRepository;
use Exception;

class PayoutService
{
    private $payoutRepository;

    public function __construct(PayoutRepository $payoutRepository)
    {
        $this->payoutRepository = $payoutRepository;
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


}
