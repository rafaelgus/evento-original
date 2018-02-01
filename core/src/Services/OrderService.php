<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Order;
use EventoOriginal\Core\Entities\OrderDetail;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Entities\VisitorEvent;
use EventoOriginal\Core\Enums\MovementType;
use EventoOriginal\Core\Enums\PaymentStatus;
use EventoOriginal\Core\Persistence\Repositories\OrderRepository;
use Money\Currency;
use Money\Money;
use DateTime;
use EventoOriginal\Core\Entities\Billing;
use EventoOriginal\Core\Entities\Shipping;
use EventoOriginal\Core\Enums\OrderStatus;

class OrderService
{
    private $orderRepository;
    private $walletService;
    private $orderDetailService;
    /**
     * @var VisitorEventService
     */
    private $visitorEventService;

    /**
     * OrderService constructor.
     * @param OrderRepository $orderRepository
     * @param WalletService $walletService
     * @param OrderDetailService $orderDetailService
     * @param VisitorEventService $visitorEventService
     */
    public function __construct(
        OrderRepository $orderRepository,
        WalletService $walletService,
        OrderDetailService $orderDetailService,
        VisitorEventService $visitorEventService
    ) {
        $this->orderRepository = $orderRepository;
        $this->walletService = $walletService;
        $this->orderDetailService = $orderDetailService;
        $this->visitorEventService = $visitorEventService;
    }

    /**
     * @param int $id
     * @return null|Order
     */
    public function findById(int $id)
    {
        return $this->orderRepository->findById($id);
    }

    public function liquidateAffiliateCommission(Order $order, User $seller, VisitorEvent $visitorEvent)
    {
        $article = $visitorEvent->getArticle();

        $articleCommission = $article->getCategory()->getAffiliateCommission();

        $order = $this->orderRepository->findById($order->getId());
        
        if ($order->getPayment()->getStatus() === PaymentStatus::STATUS_PAYMENT_APPROVE) {
            $orderDetail = $order->getOrdersDetail()->filter(function (OrderDetail $orderDetail) use ($article) {
                return $orderDetail->getArticle()->getId() === $article->getId();
            });

            if (count($orderDetail) > 0) {
                $amount = $orderDetail[0]->getMoney()->getAmount();
                $quantity = $orderDetail[0]->getQuantity();

                $sellerCommission = ($amount * $quantity) * ($articleCommission / 100);

                $moneyCommission = new Money($sellerCommission, new Currency('EUR'));

                $this->walletService->addBalance(
                    $seller->getWallet(),
                    $moneyCommission,
                    MovementType::AFFILIATE_COMMISSION_CREDIT,
                    $order
                );

                $order->setReferralVisitorEvent($visitorEvent);
                $this->orderRepository->save($order);

                logger()->notice("Liquidate affiliate commission done: Order " . $order->getId());
            }
        } else {
            logger()->notice("Affiliate commission not valid, the payment is not approve: Order " . $order->getId());
        }
    }

    /**
     * @param array $details
     * @param User $user
     * @param Shipping $shipping
     * @param Billing $billing
     * @return Order
     */
    public function create(array $details, User $user = null, Billing $billing = null, Shipping $shipping = null)
    {
        $order = new Order();

        $order->setOrdersDetail($details);
        $order->setCreateDate(new DateTime('now'));
        $order->setStatus(OrderStatus::STATUS_PENDING);

        if ($user) {
            $order->setUser($user);
        }

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
