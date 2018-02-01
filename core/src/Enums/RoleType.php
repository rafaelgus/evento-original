<?php
namespace EventoOriginal\Core\Enums;

use MyCLabs\Enum\Enum;

class RoleType extends Enum
{
    const ADMIN = 'admin';
    const CUSTOMER = 'customer';
    const DESIGNER = 'designer';
    const SELLER = 'seller';
}
