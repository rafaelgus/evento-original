<?php
namespace Tests\Unit;

use EventoOriginal\Core\Entities\Order;
use EventoOriginal\Core\Infrastructure\Payments\PaymentGatewayFactory;
use EventoOriginal\Core\Persistence\Repositories\PaymentRepository;
use EventoOriginal\Core\Services\PaymentService;
use Tests\TestCase;
use Mockery as m;

class PaymentServiceTest extends TestCase
{
    private $paymentService;

    /**
     * @before
     */
    public function before()
    {
        $paymentRepository = m::mock(PaymentRepository::class);
        $paymentGatewayFactory = m::mock(PaymentGatewayFactory::class);
        $this->paymentService = $this->getService('PaymentService');
        $this->set($this->paymentService, 'paymentRepository', $paymentRepository);
        $this->set($this->paymentService, 'paymentGatewayFactory', $paymentGatewayFactory);
    }

    public function testPreparePaymentWithEmptyData()
    {
        $data = [];
        $order = m::mock(Order::class);
        $this->expectException('Exception');
        $this->paymentService->prepare($data, $order);
    }
}