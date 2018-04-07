<?php
namespace EventoOriginal\Core\Enums;

use MyCLabs\Enum\Enum;

class UserRole extends Enum
{
    const CUSTOMER = 'customer';
    const ADMINISTRATOR = 'admin';
    const SELLER = 'seller';
    const DESIGNER = 'designer';
}
