<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use EventoOriginal\Core\Services\OrderService;
use Illuminate\Support\Collection;
use Yajra\DataTables\Contracts\DataTable;

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

    public function getDataTables()
    {
        $orders = $this->orderService->findAll();

        $ordersCollection = new Collection();

        foreach ($orders as $order) {
            $ordersCollection->push([
                'Id' => $order->getId(),
                'Fecha' => $order->getCreateDate()->format('Y-m-d'),
                'Estado' => $order->getStatus(),
                'Tipo' => '',
                'Opciones' => ''
            ]);
        }

        return DataTable::of($ordersCollection)->make(true);
    }
}
