<?php
namespace Tests\Integration\Infrastructure\Payout;

use EventoOriginal\Core\Entities\Payout;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Infrastructure\Payouts\Services\PaypalPayoutService;
use Money\Currency;
use Money\Money;
use Tests\TestCase;
use Mockery as m;

class PaypalPayoutServiceTest extends TestCase
{
    /**
     * @var PaypalPayoutService
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
        $userMock->shouldReceive('getEmail')->times(2)->andReturn('test@eventooriginal.com');

        $payoutMock = m::mock(Payout::class);

        $money = new Money(110, new Currency('EUR'));

        $payoutMock->shouldReceive('getOriginalMoney')->times(2)->andReturn($money);
        $payoutMock->shouldReceive('getUser')->times(1)->andReturn($userMock);
        $payoutMock->shouldReceive('getReceiver')->times(1)->andReturn($userMock);
        $payoutMock->shouldReceive('setRequestData')->times(1)->andReturn(null);
        $payoutMock->shouldReceive('setResponseData')->times(1)->andReturn(null);
        $payoutMock->shouldReceive('setStatus')->times(1)->andReturn(null);
        $payoutMock->shouldReceive('setExternalId')->times(1)->andReturn(null);

        $this->paypalPayoutService->send($payoutMock);
    }
}
