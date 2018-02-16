<?php
namespace App\Providers;

use App\Events\DesignApproved;
use App\Events\DesignRejected;
use App\Events\PaymentAccepted;
use App\Events\PayoutRefunded;
use App\Events\UserRegistered;
use App\Listeners\LiquidateAffiliateCommission;
use App\Listeners\RefundPayoutAmount;
use App\Listeners\SendDesignApprovedEmail;
use App\Listeners\SendDesignRejectedEmail;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        PaymentAccepted::class => [
            LiquidateAffiliateCommission::class,
        ],
        UserRegistered::class => [
            SendWelcomeEmail::class,
        ],
        PayoutRefunded::class => [
            RefundPayoutAmount::class,
        ],
        DesignApproved::class => [
            SendDesignApprovedEmail::class,
        ],
        DesignRejected::class => [
            SendDesignRejectedEmail::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
