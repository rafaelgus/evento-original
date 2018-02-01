<?php
namespace App\Events;

use EventoOriginal\Core\Entities\Payout;
use Illuminate\Queue\SerializesModels;

class PayoutRefunded
{
    use SerializesModels;

    public $payout;

    public function __construct(Payout $payout)
    {
        $this->payout = $payout;
    }
}
