<?php
namespace App\Events;

use EventoOriginal\Core\Entities\Payment;
use Illuminate\Queue\SerializesModels;

class PaymentAccepted
{
    use SerializesModels;

    public $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }
}
