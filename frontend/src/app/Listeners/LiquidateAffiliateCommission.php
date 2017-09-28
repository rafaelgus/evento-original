<?php

namespace App\Listeners;

use App\Events\PaymentAccepted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LiquidateAffiliateCommission implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PaymentAccepted $event
     * @return void
     */
    public function handle(PaymentAccepted $event)
    {
        if (true) {
            $this->release(30);
        }

        logger()->info('Pago aceptado');
    }
}
