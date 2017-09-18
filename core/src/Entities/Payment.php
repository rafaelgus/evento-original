<?php
namespace EventoOriginal\Core\Entities;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use EventoOriginal\Core\Infrastructure\Payments\Interfaces\PayerInterface;
use EventoOriginal\Core\Infrastructure\Payments\Interfaces\PaymentInterface;
use Money\Money;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\PaymentRepository")
 * @ORM\Table(name="payment")
 */
class Payment implements PaymentInterface
{
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVE = 'approve';
    const STATUS_REFUSED = 'refused';
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="datetime")
     */
    private $date;
    /**
     * @ORM\Column(type="integer")
     */
    private $originalAmount;
    /**
     * @ORM\Column(type="string")
     */
    private $originalCurrency;
    /**
     * @ORM\Column(type="integer")
     */
    private $paidAmount;
    /**
     * @ORM\Column(type="string")
     */
    private $paidCurrency;
    /**
     * @ORM\OneToOne(targetEntity="Payment", inversedBy="payment")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    private $order;
    /**
     * @ORM\Column(type="string")
     */
    private $status;
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="payments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    /**
     * @ORM\Column(type="string")
     */
    private $gateway;
    /**
     * @ORM\Column(type="string")
     */
    private $requestData;
    /**
     * @ORM\Column(type="string")
     */
    private $responseData;
    /**
     * @ORM\Column(type="string")
     */
    private $description;
    /**
     * @ORM\Column(type="string")
     */
    private $data;
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;
    }
    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }
    /**
     * @param Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
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
     * Get payer of the payment
     *
     * @return PayerInterface
     */
    public function getPayer()
    {
        return $this->user;
    }
    /**
     * Set payer of the payment
     *
     * @param PayerInterface $payer
     */
    public function setPayer(PayerInterface $payer)
    {
        $this->user = $payer;
    }
    /**
     * Get payment gateway
     *
     * @return string
     */
    public function getGateway()
    {
        return $this->getGateway();
    }
    /**
     * Set payment gateway
     *
     * @param string $gateway
     */
    public function setGateway(string $gateway)
    {
        $this->gateway = $gateway;
    }
    /**
     * Get original money of the payment
     *
     * @return Money
     */
    public function getOriginalMoney()
    {
        $money = new Money($this->originalAmount, $this->originalCurrency);
        return $money;
    }
    /**
     * Set original money of the payment
     *
     * @param Money $money
     */
    public function setOriginalMoney(Money $money)
    {
        $this->originalCurrency = $money->getCurrency();
        $this->originalAmount = $money->getAmount();
    }
    /**
     * Get paid money of the payment
     *
     * @return Money
     */
    public function getPaidMoney()
    {
        $money = new Money($this->paidAmount, $this->paidCurrency);
        return $money;
    }
    /**
     * Set paid money of the payment
     *
     * @param Money $money
     */
    public function setPaidMoney(Money $money)
    {
        $this->paidAmount = $money->getAmount();
        $this->paidCurrency = $money->getCurrency();
    }
    /**
     * Get data to request the payment
     *
     * @return array
     */
    public function getRequestData()
    {
        return json_decode($this->requestData);
    }
    /**
     * Set data to request the payment
     *
     * @param array $data
     */
    public function setRequestData(array $data)
    {
        $this->requestData = json_encode($data);
    }
    /**
     * Get response data of the payment
     *
     * @return array
     */
    public function getResponseData()
    {
        return json_decode($this->responseData);
    }
    /**
     * Set response data of the payment
     *
     * @param array $data
     */
    public function setResponseData(array $data)
    {
        $this->responseData = json_encode($data);
    }
    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }
    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
    /**
     * @param string $data
     */
    public function setData(string $data)
    {
        $this->data = $data;
    }
}