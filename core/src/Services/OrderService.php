<?php
namespace EventoOriginal\Core\Services;

use DateTime;
use EventoOriginal\Core\Entities\Billing;
use EventoOriginal\Core\Entities\Order;
use EventoOriginal\Core\Entities\Shipping;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Enums\OrderStatus;
use EventoOriginal\Core\Persistence\Repositories\OrderRepository;

class OrderService
{
    private $orderRepository;
    private $orderDetailService;

    public function __construct(OrderRepository $orderRepository, OrderDetailService $orderDetailService)
    {
        $this->orderRepository = $orderRepository;
        $this->orderDetailService = $orderDetailService;
    }

    /**
     * @param array $details
     * @param User $user
     * @param Shipping $shipping
     * @param Billing $billing
     * @return Order
     */
    public function create(array $details, User $user, Billing $billing = null, Shipping $shipping = null)
    {
        $order = new Order();

        $order->setOrdersDetail($details);
        $order->setCreateDate(new DateTime('now'));
        $order->setStatus(OrderStatus::STATUS_PENDING);
        $order->setUser($user);

        if ($billing) {
            $order->setBilling($billing);
        }
        if ($shipping) {
            $order->setShipping($shipping);
        }

        $this->orderRepository->save($order);
        $this->orderDetailService->setOrder($details, $order);

        return $order;
    }

    public function addShipping(Order $order, Shipping $shipping)
    {
        $order->setShipping($shipping);
        $this->save($order);
    }

    /**
     * @param Order $order
     * @param Billing $billing
     */
    public function addBilling(Order $order, Billing $billing)
    {
        $order->setBilling($billing);
        $this->save($order);
    }

    /**
     * @param int $orderId
     * @return null|Order
     */
    public function findById(int $orderId)
    {
        return $this->orderRepository->find($orderId);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->orderRepository->findAll();
    }

    public function findAllByUser(User $user)
    {
        return $this->orderRepository->findAllByUser($user);
    }

    public function save(Order $order)
    {
        $this->orderRepository->save($order);
    }
}