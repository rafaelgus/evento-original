<?php
namespace EventoOriginal\Core\Enums;

use MyCLabs\Enum\Enum;

class VisitorEventType extends Enum
{
    const VISITOR_LANDING_CREATED = 'VisitorLandingCreated';
    const VISITOR_LANDING_REASSIGNED = 'VisitorLandingReassigned';
    const AFFILIATE_REFERRAL_ARRIVAL = 'AffiliateReferralArrival';
}
