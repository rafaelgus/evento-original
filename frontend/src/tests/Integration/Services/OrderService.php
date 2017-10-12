<?php
namespace Integration\Unit\Services;

use EventoOriginal\Core\Entities\Article;
use EventoOriginal\Core\Entities\Order;
use EventoOriginal\Core\Entities\OrderDetail;
use Illuminate\Foundation\Auth\User;
use Money\Currency;
use Money\Money;
use Tests\TestCase;
use Mockery as m;

class OrderService extends TestCase
{
    /**
     * @var \EventoOriginal\Core\Services\OrderService
     */
    private $orderService;

    public function setUp()
    {
        parent::setUp();

        $this->orderService = $this->app->make(OrderService::class);
    }

    public function testLiquidateAffiliateCommission()
    {
        $articleMock = m::mock(Article::class);

        $orderDetailMock = m::mock(OrderDetail::class);
        $orderDetailMock->shouldReceive('getArticle')->times(1)->andReturn($articleMock);

        $money = new Money(50, new Currency('EUR'));
        $orderDetailMock->shouldReceive('getMoney')->times(1)->andReturn($money);

        $orderMock = m::mock(Order::class);
        $orderMock->shouldReceive('getOrderDetails')->times(1)->andReturn([$orderDetailMock]);

        $sellerMock = m::mock(User::class);
    }
}
