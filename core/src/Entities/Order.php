<?php
namespace EventoOriginal\Core\Entities;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Money\Currency;
use Money\Money;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\OrderRepository")
 * @ORM\Table(name="orders")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", name="create_date")
     */
    private $createDate;

    /**
     * @ORM\OneToMany(targetEntity="OrderDetail", mappedBy="order", cascade={"persist"}, fetch="EAGER")
     */
    private $ordersDetail;

    /**
     * @ORM\OneToOne(targetEntity="Payment", mappedBy="order")
     */
    private $payment;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private $user;

    /**
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="VisitorEvent")
     * @ORM\JoinColumn(name="referral_visitor_event_id", referencedColumnName="id", nullable=true)
     */
    private $referralVisitorEvent;

     /**
     * @ORM\OneToOne(targetEntity="Billing")
     * @ORM\JoinColumn(name="billing_id", referencedColumnName="id")
     */
    private $billing;

    /**
     * One Cart has One Customer.
     * @ORM\OneToOne(targetEntity="Shipping", inversedBy="order")
     * @ORM\JoinColumn(name="shipping_id", referencedColumnName="id")
     */
    private $shipping;

    public function __construct()
    {
        $this->ordersDetail = new ArrayCollection();
    }
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return datetime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }
    /**
     * @param datetime $date
     */
    public function setCreateDate(DateTime $date)
    {
        $this->createDate = $date;
    }
    /**
     * @return ArrayCollection
     */
    public function getOrdersDetail()
    {
        return $this->ordersDetail;
    }
    /**
     * @param array $ordersDetail
     */
    public function setOrdersDetail(array $ordersDetail)
    {
        $this->ordersDetail = $ordersDetail;
    }
    /**
     * @return Payment
     */
    public function getPayment()
    {
        return $this->payment;
    }
    /**
     * @param Payment $payment
     */
    public function setPayment(Payment $payment)
    {
        $this->payment = $payment;
    }
    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getTotal()
    {
        $details = $this->getOrdersDetail();
        $total = 0;

        foreach ($details->toArray() as $detail) {
            if ($detail->getDiscount()) {
                $total = $total - $detail->getMoney()->getAmount();
            } else {
                $total = $total + ($detail->getMoney()->getAmount() * $detail->getQuantity());
            }
        }

        return new Money($total, new Currency('EUR'));
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @param OrderDetail $orderDetail
     */
    public function addOrderDetail(OrderDetail $orderDetail)
    {
        $this->ordersDetail[] = $orderDetail;
    }

    /**
     * @return VisitorEvent
     */
    public function getReferralVisitorEvent()
    {
        return $this->referralVisitorEvent;
    }

    /**
     * @param VisitorEvent $referralVisitorEvent
     */
    public function setReferralVisitorEvent(VisitorEvent $referralVisitorEvent)
    {
        $this->referralVisitorEvent = $referralVisitorEvent;
    }

    /**
     * @return Billing
     */
    public function getBilling()
    {
        return $this->billing;
    }

    /**
     * @param Billing $billing
     */
    public function setBilling(Billing $billing)
    {
        $this->billing = $billing;
    }

    /**
     * @return Shipping
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @param Shipping $shipping
     */
    public function setShipping(Shipping $shipping)
    {
        $this->shipping = $shipping;
    }
}
