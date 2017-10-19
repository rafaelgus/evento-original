<?php
namespace App\Http\Controllers\Frontend;

use EventoOriginal\Core\Services\OrderDetailService;
use EventoOriginal\Core\Services\OrderService;

class AccountController
{
    private $orderService;
    private $orderDetailService;

    public function __construct(OrderService $orderService, OrderDetailService $orderDetailService)
    {
        $this->orderService = $orderService;
        $this->orderDetailService = $orderDetailService;
    }

    public function getAccount()
    {
        $user = current_user();
        $orders = $this->orderService->findAllByUser($user);

        return view('frontend.profile.my_account')
            ->with('orders', $orders);
    }

    public function getDetails(int $id)
    {
        $details = $this->orderDetailService->findByOrder($id);

        return view('frontend.profile.orderDetails')
            ->with('details', $details)
            ->with('orderNumber', $id);
    }
}