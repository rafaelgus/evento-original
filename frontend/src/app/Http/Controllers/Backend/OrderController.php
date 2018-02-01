<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use EventoOriginal\Core\Services\OrderService;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function show(int $id)
    {
        $order = $this->orderService->findById($id);

        if (!$order) {
            abort(404);
        }

        return view('backend.admin.orders.show')->withOrder($order);
    }
}
