<?php
namespace EventoOriginal\Core\Enums;

use MyCLabs\Enum\Enum;

class DesignStatus extends Enum
{
    const CREATED = 'created';
    const IN_REVIEW = 'in_review';
    const REJECTED = 'rejected';
    const PUBLISHED = 'published';
}
