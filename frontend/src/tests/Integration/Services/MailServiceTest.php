<?php
namespace Tests\Integration\Services;

use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Services\MailService;
use Tests\TestCase;
use Mockery as m;

class MailServiceTest extends TestCase
{
    /**
     * @var \EventoOriginal\Core\Services\MailService
     */
    private $mailService;

    public function setUp()
    {
        parent::setUp();

        $this->mailService = $this->app->make(MailService::class);
    }

    public function testSendWelcome()
    {
        $userMock = m::mock(User::class);
        $userMock->shouldReceive('getName')->times(1)->andReturn('emi');
        $userMock->shouldReceive('getEmail')->times(1)->andReturn('emiliano.rodriguez26@gmail.com');

        $this->mailService->sendWelcome($userMock);
    }
}
