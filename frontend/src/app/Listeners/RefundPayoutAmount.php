<?php

namespace App\Listeners;

use App\Events\PayoutRefunded;
use EventoOriginal\Core\Enums\MovementType;
use EventoOriginal\Core\Persistence\Repositories\PayoutRepository;
use EventoOriginal\Core\Services\PayoutService;
use EventoOriginal\Core\Services\WalletService;
use Exception;

class RefundPayoutAmount
{
    private $walletService;
    private $payoutRepository;

    public function __construct(WalletService $walletService, PayoutRepository $payoutRepository)
    {
        $this->walletService = $walletService;
        $this->payoutRepository = $payoutRepository;
    }

    /**
     * Handle the event.
     *
     * @param  PayoutRefunded $event
     * @throws Exception
     * @return void
     */
    public function handle(PayoutRefunded $event)
    {
        $payout = $event->payout;

        if (!in_array($payout->getStatus(), PayoutService::$statusToRefund) && !$payout->isRefunded()) {
            throw new Exception("Invalid status to refund payout " . $payout->getId());
        }

        $this->walletService->addBalance(
            $payout->getUser()->getWallet(),
            $payout->getOriginalAmount(),
            MovementType::PAYOUT_REFUND
        );

        $payout->setRefunded(true);

        $this->payoutRepository->save($payout);
    }
}
