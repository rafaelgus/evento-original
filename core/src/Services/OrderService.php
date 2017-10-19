<?php
namespace EventoOriginal\Core\Services;

use DateTime;
use EventoOriginal\Core\Entities\Order;
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
     * @return Order
     */
    public function create(array $details, User $user)
    {
        $order = new Order();

        $order->setOrdersDetail($details);
        $order->setCreateDate(new DateTime('now'));
        $order->setStatus(OrderStatus::STATUS_PENDING);
        $order->setUser($user);

        $this->orderRepository->save($order);
        $this->orderDetailService->setOrder($details, $order);

        return $order;
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
}