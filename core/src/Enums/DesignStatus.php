<?php
namespace EventoOriginal\Core\Enums;

use MyCLabs\Enum\Enum;

class DesignStatus extends Enum
{
    const CREATED = 'created';
    const IN_REVIEW = 'in_review';
    const NEED_CHANGES = 'need_changes';
    const ACCEPTED = 'accepted';
    const PUBLISHED = 'published';
}
