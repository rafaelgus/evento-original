<?php
namespace Tests\Integration\Infrastructure\Payout;

use EventoOriginal\Core\Entities\Payout;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Infrastructure\Payout\PaypalPayoutService;
use Tests\TestCase;
use Mockery as m;

class PaypalPayoutServiceTest extends TestCase
{
    /**
     * @var \EventoOriginal\Core\Infrastructure\Payout\PaypalPayoutService
     */
    private $paypalPayoutService;

    public function setUp()
    {
        parent::setUp();

        $this->paypalPayoutService = $this->app->make(PaypalPayoutService::class);
    }

    public function testSend()
    {
        $userMock = m::mock(User::class);
        $userMock->shouldReceive('getEmail')->times(1)->andReturn('test@eventooriginal.com');

        $payoutMock = m::mock(Payout::class);
        $payoutMock->shouldReceive('getOriginalAmount')->times(1)->andReturn(110);
        $payoutMock->shouldReceive('getOriginalCurrency')->times(1)->andReturn('EUR');
        $payoutMock->shouldReceive('getUser')->times(1)->andReturn($userMock);

        $this->paypalPayoutService->send($payoutMock);
    }
}
