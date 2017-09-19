<?php
namespace App\Http\Controllers\Frontend;

use EventoOriginal\Core\Services\OrderDetailService;
use EventoOriginal\Core\Services\OrderService;
use EventoOriginal\Core\Services\PaymentService;

class CheckoutController
{
    private $orderService;
    private $orderDetailService;
    private $paymentService;

    public function __construct(
        OrderService $orderService,
        OrderDetailService $orderDetailService,
        PaymentService $paymentService
    ) {
        $this->orderDetailService = $orderDetailService;
        $this->paymentService = $paymentService;
        $this->orderService = $orderService;
    }

    public function checkout()
    {

    }
}