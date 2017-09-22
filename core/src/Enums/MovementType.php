<?php
namespace EventoOriginal\Core\Enums;

use MyCLabs\Enum\Enum;

class MovementType extends Enum
{
    const DEBIT = "debit";
    const CREDIT = "credit";
    const EXTRACTION = "extraction";
}
