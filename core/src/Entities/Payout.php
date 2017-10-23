<?php
namespace EventoOriginal\Core\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use EventoOriginal\Core\Infrastructure\Payouts\Interfaces\PayoutInterface;
use EventoOriginal\Core\Infrastructure\Payouts\Interfaces\ReceiverInterface;
use Money\Currency;
use Money\Money;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\PaymentRepository")
 * @ORM\Table(name="payments")
 */
class Payout implements PayoutInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $originalAmount;

    /**
     * @ORM\Column(type="string")
     */
    private $originalCurrency;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $paidAmount;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $paidCurrency;

    /**
     * @ORM\Column(type="string")
     */
    private $description;

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
     * @ORM\Column(type="string", nullable=true)
     */
    private $responseData;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getOriginalAmount()
    {
        return $this->originalAmount;
    }

    /**
     * @param int $originalAmount
     */
    public function setOriginalAmount(int $originalAmount)
    {
        $this->originalAmount = $originalAmount;
    }

    /**
     * @return string
     */
    public function getOriginalCurrency()
    {
        return $this->originalCurrency;
    }

    /**
     * @param string $originalCurrency
     */
    public function setOriginalCurrency(string $originalCurrency)
    {
        $this->originalCurrency = $originalCurrency;
    }

    /**
     * @return int
     */
    public function getPaidAmount()
    {
        return $this->paidAmount;
    }

    /**
     * @param int $paidAmount
     */
    public function setPaidAmount(int $paidAmount)
    {
        $this->paidAmount = $paidAmount;
    }

    /**
     * @return string
     */
    public function getPaidCurrency()
    {
        return $this->paidCurrency;
    }

    /**
     * @param string $paidCurrency
     */
    public function setPaidCurrency(string $paidCurrency)
    {
        $this->paidCurrency = $paidCurrency;
    }

    /**
     * @return string
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

    /**
     * @return string
     */
    public function getGateway()
    {
        return $this->gateway;
    }

    /**
     * @param string $gateway
     */
    public function setGateway(string $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * @return string
     */
    public function getRequestData()
    {
        return $this->requestData;
    }

    /**
     * @param string $requestData
     */
    public function setRequestData(string $requestData)
    {
        $this->requestData = $requestData;
    }

    /**
     * @return string
     */
    public function getResponseData()
    {
        return $this->responseData;
    }

    /**
     * @param string $responseData
     */
    public function setResponseData(string $responseData)
    {
        $this->responseData = $responseData;
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
     * Get receiver of the payout
     *
     * @return User
     */
    public function getReceiver()
    {
        return $this->user;
    }

    /**
     * Set receiver of the payout
     *
     * @param User $receiver
     */
    public function setReceiver(User $receiver)
    {
        $this->user = $receiver;
    }

    /**
     * Get original money of the payout
     *
     * @return Money
     */
    public function getOriginalMoney()
    {
        return new Money(
            $this->getOriginalAmount(),
            new Currency($this->getOriginalCurrency())
        );
    }

    /**
     * Set original money of the payout
     *
     * @param Money $originalMoney
     */
    public function setOriginalMoney(Money $originalMoney)
    {
        $this->setOriginalAmount($originalMoney->getAmount());
        $this->setOriginalCurrency($originalMoney->getCurrency()->getCode());
    }
}
