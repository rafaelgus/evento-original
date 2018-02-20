<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use EventoOriginal\Core\Services\OrderService;
use Illuminate\Support\Collection;
use Yajra\DataTables\Facades\DataTables;

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

    public function index()
    {
        return view('backend.admin.orders.index');
    }

    public function getOrders()
    {
        $orders = $this->orderService->findAll();

        $ordersCollection = new Collection();

        foreach ($orders as $order) {
            $shipping = $order->getShipping();

            if (!$shipping) {
                $state = trans('order_state.branch_withdrawal');
            } else {
                $state = trans('order_state.home_delivery');
            }

            $options = '<a href="/management/'. $order->getId() . '/order/">ver</a>';

            if ($order->getUser()) {
                $ordersCollection->push([
                    'id' => $order->getId(),
                    'date' => $order->getCreateDate()->format('Y-m-d'),
                    'state' => $order->getStatus(),
                    'type' => $state,
                    'total' => formatted_money($order->getTotal()),
                    'user' => $order->getUser()->getEmail(),
                    'options' => $options
                ]);
            }
        }

        return DataTables::of($ordersCollection)->make(true);
    }
}
