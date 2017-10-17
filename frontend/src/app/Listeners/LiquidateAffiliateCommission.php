<?php

namespace App\Listeners;

use App\Events\PaymentAccepted;
use EventoOriginal\Core\Persistence\Repositories\VisitorEventRepository;
use EventoOriginal\Core\Services\OrderService;
use EventoOriginal\Core\Services\UserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LiquidateAffiliateCommission implements ShouldQueue
{
    use InteractsWithQueue;

    private $visitorEventRepository;
    private $userService;
    private $orderService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(
        VisitorEventRepository $visitorEventRepository,
        UserService $userService,
        OrderService $orderService
    ) {
        $this->visitorEventRepository = $visitorEventRepository;
        $this->userService = $userService;
        $this->orderService = $orderService;
    }

    /**
     * Handle the event.
     *
     * @param  PaymentAccepted $event
     * @return void
     */
    public function handle(PaymentAccepted $event)
    {
        $payment = $event->payment;

        $order = $payment->getOrder();

        $affiliateReferralEvent = $this->visitorEventRepository->findAffiliateReferralInOrder($order);

        if ($affiliateReferralEvent) {
            $seller = $this->userService->findByAffiliateCode($affiliateReferralEvent->getAffiliateCodeReferral);

            if ($seller) {
                $this->orderService->liquidateAffiliateCommission(
                    $order,
                    $seller,
                    $affiliateReferralEvent->getArticle()
                );
            }
        }
    }
}
