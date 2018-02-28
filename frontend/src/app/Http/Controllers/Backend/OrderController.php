<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use EventoOriginal\Core\Enums\OrderStatus;
use EventoOriginal\Core\Services\OrderService;
use EventoOriginal\Core\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    private $orderService;
    private $shippingService;

    public function __construct(
        OrderService $orderService,
        ShippingService $shippingService
    ) {
        $this->orderService = $orderService;
        $this->shippingService = $shippingService;
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

            if ($order->getUser()) {
                $ordersCollection->push([
                    'id' => $order->getId(),
                    'date' => $order->getCreateDate()->format('Y-m-d'),
                    'state' => $order->getStatus(),
                    'type' => $state,
                    'total' => formatted_money($order->getTotal()),
                    'user' => $order->getUser()->getEmail(),
                ]);
            }
        }

        return DataTables::of($ordersCollection)->make(true);
    }

    public function update(int $id, Request $request)
    {
        $order = $this->orderService->findById($id);

        if ($order->getShipping()) {
            $shipping = $order->getShipping();

            $shipping->setStatus($request->input('status'));
            $shipping->setTrackingNumber($request->input('trackingNumber'));

            $this->shippingService->update($shipping);
        }
        $order->setComment($request->input('comment'));
        $order->setStatus(OrderStatus::STATUS_COMMITTED);

        $this->orderService->save($order);

        Session::flash('message', 'La orden se actualizo correctamente');

        return redirect()->to('/management/orders/'. $id . '/order');
    }
}
