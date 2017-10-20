<?php
namespace EventoOriginal\Core\Enums;

use MyCLabs\Enum\Enum;

class PayoutStatus extends Enum
{
    const CREATED = 'created';
    const DENIED = 'denied';
    const PENDING = 'pending';
    const PROCESSING = 'processing';
    const SUCCESS = 'success';
    const CANCELLED = 'cancelled';
}
