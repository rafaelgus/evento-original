<?php

namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Entities\VisitorLanding;
use EventoOriginal\Core\Enums\VisitorEventType;
use EventoOriginal\Core\Persistence\Repositories\UserRepository;
use EventoOriginal\Core\Persistence\Repositories\VisitorLandingRepository;
use Exception;

class VisitorLandingService
{
    private $visitorLandingRepository;
    private $visitorEventService;
    private $userRepository;

    public function __construct(
        VisitorLandingRepository $visitorLandingRepository,
        VisitorEventService $visitorEventService,
        UserRepository $userRepository
    ) {
        $this->visitorLandingRepository = $visitorLandingRepository;
        $this->visitorEventService = $visitorEventService;
        $this->userRepository = $userRepository;
    }

    public function make()
    {
        $visitorLanding = new VisitorLanding();
        $this->visitorLandingRepository->save($visitorLanding);

        session()->put('visitorLandingId', $visitorLanding->getId());

        $this->visitorEventService->create(array_merge([
            'type' => VisitorEventType::VISITOR_LANDING_CREATED,
        ], visitorData()));

        return $visitorLanding;
    }

    public function sync()
    {
        $user = current_user();

        if (!empty($user)) {
            return $this->syncUser($user);
        }
        if (!session()->has('visitorLandingId')) {
            return $this->make();
        }
    }

    /**
     * Synchronize current user with its visitor_landing_id
     */
    private function syncUser(User $user)
    {
        if (empty(current_user())) {
            throw new Exception("User is not logged in", 1);
        }

        $currentVisitorLanding = current_visitor_landing();

        if (empty($user->getVisitorLanding())) {
            if (!empty($currentVisitorLanding)) {
                $currentVisitorLanding->setUser($user);
                $this->visitorLandingRepository->save($currentVisitorLanding);

                return $currentVisitorLanding;
            }
        } else {
            return $this->assign($user->getVisitorLanding());
        }

        logger()->info('Creating new visitor_landing');
        $newVisitorLanding = $this->make();
        logger()->info('Setting new visitor_landing to user');
        $newVisitorLanding->setUser($user);
        $this->visitorLandingRepository->save($newVisitorLanding);
        return $newVisitorLanding;
    }

    public function assign(VisitorLanding $visitorLanding)
    {
        if (visitor_landing_id() !== $visitorLanding->getId()) {
            $this->visitorEventService->assignEvents(current_visitor_landing(), $visitorLanding);

            session()->put('visitorLandingId', $visitorLanding->getId());
            logger()->info(sprintf('Assing %s visitor_landing_id', $visitorLanding->getId()));
            $this->visitorEventService->create(array_merge(['type' => VisitorEventType::VISITOR_LANDING_REASSIGNED], visitorData()));
        }

        return $visitorLanding;
    }
}
