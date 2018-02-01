<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Article;
use EventoOriginal\Core\Entities\Country;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Entities\VisitorEvent;
use EventoOriginal\Core\Entities\VisitorLanding;
use EventoOriginal\Core\Persistence\Repositories\VisitorEventRepository;
use EventoOriginal\Core\Persistence\Repositories\VisitorLandingRepository;

class VisitorEventService
{
    private $visitorEventRepository;
    private $visitorLandingRepository;

    public function __construct(
        VisitorEventRepository $visitorEventRepository,
        VisitorLandingRepository $visitorLandingRepository
    ) {
        $this->visitorEventRepository = $visitorEventRepository;
        $this->visitorLandingRepository = $visitorLandingRepository;
    }

    public function create(array $data)
    {
        $event = new VisitorEvent();
        $event->setType(array_get($data, 'type'));
        $event->setUrl(array_get($data, 'url'));
        $event->setUserAgent(array_get($data, 'user_agent'));
        $event->setIp(array_get($data, 'ip'));

        if (!empty($data['visitor_landing_id'])) {
            $visitorLandingId = $data['visitor_landing_id'];
        } else {
            $visitorLandingId = visitor_landing_id();
        }

        $visitorLanding = $this->visitorLandingRepository->findOneById($visitorLandingId);

        $event->setVisitorLanding($visitorLanding);

        if (array_has($data, 'article') &&
            is_a($data['article'], Article::class)
        ) {
            $event->setArticle($data['article']);
        }

        if (array_has($data, 'affiliate_code_referral')) {
            $event->setAffiliateCodeReferral($data['affiliate_code_referral']);
        }

        return $this->visitorEventRepository->save($event);
    }

    public function assignEvents(VisitorLanding $oldVisitorLanding, VisitorLanding $newVisitorLanding)
    {
        $this->visitorEventRepository->assignEvents($oldVisitorLanding, $newVisitorLanding);
    }

    public function getAllIpsByVisitorLanding(VisitorLanding $visitorLanding)
    {
        return $this->visitorEventRepository->getAllIpsByVisitorLanding($visitorLanding);
    }

    public function findOneById(int $id)
    {
        return $this->visitorEventRepository->findOneById($id);
    }
}
