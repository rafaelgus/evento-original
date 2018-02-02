<?php

namespace EventoOriginal\Core\Infrastructure\Payouts\Enums;

use MyCLabs\Enum\Enum;

class PaypalPayoutStatus extends Enum
{
    const BLOCKED = 'blocked';
    const DENIED = 'denied';
    const FAILED = 'failed';
    const NEW = 'new';
    const ONHOLD = 'onhold';
    const PENDING = 'pending';
    const REFUNDED = 'refunded';
    const RETURNED = 'returned';
    const SUCCESS = 'success';
    const UNCLAIMED = 'unclaimed';
    const REVERSED = 'reversed';
}
