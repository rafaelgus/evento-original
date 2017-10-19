<?php
namespace App\Http\Controllers\Frontend;

use EventoOriginal\Core\Services\OrderService;

class AccountController
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function getAccount()
    {
        $user = current_user();
        $orders = $this->orderService->findAllByUser($user);

        return view('frontend.profile.my_account')
            ->with('orders', $orders);
    }
}