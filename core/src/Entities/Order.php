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
     * @ORM\OneToMany(targetEntity="OrderDetail", mappedBy="order", cascade={"persist"})
     */
    private $ordersDetail;
    /**
     * @ORM\OneToOne(targetEntity="Payment", mappedBy="payment")
     */
    private $payment;
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\Column(type="string")
     */
    private $status;

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
            $total = $detail->getMoney()->getAmount();
        }
        return new Money($total, new Currency('EU'));
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
}