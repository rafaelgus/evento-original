<?php
namespace App\Listeners;

use App\Events\PaymentAccepted;
use EventoOriginal\Core\Persistence\Repositories\VisitorEventRepository;
use EventoOriginal\Core\Services\CustomerService;
use EventoOriginal\Core\Services\OrderService;
use EventoOriginal\Core\Services\UserService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LiquidateAffiliateCommission implements ShouldQueue
{
    use InteractsWithQueue;

    private $visitorEventRepository;
    private $userService;
    private $orderService;
    private $customerService;

    /**
     * Create the event listener.
     *
     * @param VisitorEventRepository $visitorEventRepository
     * @param UserService $userService
     * @param OrderService $orderService
     * @param CustomerService $customerService
     */
    public function __construct(
        VisitorEventRepository $visitorEventRepository,
        UserService $userService,
        OrderService $orderService,
        CustomerService $customerService
    ) {
        $this->visitorEventRepository = $visitorEventRepository;
        $this->userService = $userService;
        $this->orderService = $orderService;
        $this->customerService = $customerService;
    }

    /**
     * Handle the event.
     *
     * @param  PaymentAccepted $event
     * @return void
     * @throws Exception
     */
    public function handle(PaymentAccepted $event)
    {
        try {
            $payment = $event->payment;

            $order = $payment->getOrder();

            $affiliateReferralEvent = $this->visitorEventRepository->findAffiliateReferralInOrder($order);

            if ($affiliateReferralEvent) {
                $seller = $this->customerService->findOneByAffiliateCode(
                    $affiliateReferralEvent->getAffiliateCodeReferral()
                );

                if ($seller) {
                    $seller = $seller->getUser();
                    $userVisitorLanding = $affiliateReferralEvent->getVisitorLanding();
                    $userIps = $this->visitorEventRepository->getAllIpsByVisitorLanding($userVisitorLanding);
                    $sellerIps = $this->visitorEventRepository->getAllIpsByVisitorLanding($seller->getVisitorLanding());

                    $sameIps = [];
                    foreach ($userIps as $key => $val) {
                        if (in_array($val, $sellerIps)) {
                            $sameIps[] = $val;
                        }
                    }

                    if (empty($sameIps)) {
                        $this->orderService->liquidateAffiliateCommission(
                            $order,
                            $seller,
                            $affiliateReferralEvent
                        );
                    } else {
                        logger()->warning("[FRAUD AFFILIATE CODE] User " .
                            $userVisitorLanding->getUser()->getId() . " and seller " . $seller->getId());
                    }
                }
            }
        } catch (Exception $exception) {
            logger()->error("Error Liquidating Affiliate Commission: " . $exception->getMessage());
            throw $exception;
        }
    }
}
