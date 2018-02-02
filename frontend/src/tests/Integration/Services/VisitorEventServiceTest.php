<?php
namespace Integration\Integration\Services;

use EventoOriginal\Core\Services\VisitorEventService;
use EventoOriginal\Core\Services\VisitorLandingService;
use Tests\TestCase;

class VisitorEventServiceTest extends TestCase
{
    /**
     * @var VisitorLandingService
     */
    private $visitorLandingService;

    /**
     * @var VisitorEventService
     */
    private $visitorEventService;

    public function setUp()
    {
        parent::setUp();

        $this->visitorLandingService = $this->app->make(VisitorLandingService::class);
        $this->visitorEventService = $this->app->make(VisitorEventService::class);
    }

    public function testGetAllIps()
    {
        $visitorLanding = $this->visitorLandingService->make();

        dd($this->visitorEventService->getAllIpsByVisitorLanding($visitorLanding));
    }
}
