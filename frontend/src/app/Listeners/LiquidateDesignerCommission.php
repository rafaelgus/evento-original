<?php
namespace App\Listeners;

use App\Events\PaymentAccepted;
use EventoOriginal\Core\Services\DesignService;
use EventoOriginal\Core\Services\OrderService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;

class LiquidateDesignerCommission implements ShouldQueue
{
    /**
     * @var DesignService
     */
    private $designService;
    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * LiquidateDesignerCommission constructor.
     * @param DesignService $designService
     * @param OrderService $orderService
     */
    public function __construct(
        DesignService $designService,
        OrderService $orderService
    ) {
        $this->designService = $designService;
        $this->orderService = $orderService;
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

            $designs = $this->designService->findInOrder($order);

            foreach ($designs as $design) {
                $this->orderService->liquidateDesignerCommission(
                    $order,
                    $design
                );
            }
        } catch (Exception $exception) {
            logger()->error("Error Liquidating Designer Commission: " . $exception->getMessage());

            throw $exception;
        }
    }
}
