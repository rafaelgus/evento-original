<?php
namespace EventoOriginal\Core\Enums;

use MyCLabs\Enum\Enum;

class PayoutStatus extends Enum
{
    const CREATED = 'created';
    const PENDING_APPROVAL = 'pending_approval';
    const PENDING = 'pending';
    const CANCELLED = 'cancelled';
    const PROCESSING = 'processing';
    const BLOCKED = 'blocked';
    const DENIED = 'denied';
    const FAILED = 'failed';
    const NEW = 'new';
    const ONHOLD = 'onhold';
    const REFUNDED = 'refunded';
    const RETURNED = 'returned';
    const SUCCESS = 'success';
    const UNCLAIMED = 'unclaimed';
    const REVERSED = 'reversed';
}
