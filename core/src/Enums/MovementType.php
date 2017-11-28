<?php
namespace EventoOriginal\Core\Enums;

use MyCLabs\Enum\Enum;

class MovementType extends Enum
{
    const DEBIT = "debit";
    const CREDIT = "credit";
    const EXTRACTION = "extraction";
    const AFFILIATE_COMMISSION_CREDIT = "affiliate_commission_credit";
    const PAYOUT_REFUND = "payout_refund";
    const PAYOUT = 'payout';
}
