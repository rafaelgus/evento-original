<?php
namespace EventoOriginal\Core\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use EventoOriginal\Core\Enums\MovementType;
use InvalidArgumentException;
use Money\Currency;
use Money\Money;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\MovementRepository")
 * @ORM\Table(name="movements")
 */
class Movement
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\Column(type="string")
     */
    private $currency;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Wallet", inversedBy="movements")
     * @ORM\JoinColumn(name="wallet_id", referencedColumnName="id")
     */
    private $wallet;

    /**
     * @ORM\ManyToOne(targetEntity="Order", fetch="EAGER")
     * @ORM\JoinColumn(name="referral_order_id", referencedColumnName="id", nullable=true)
     */
    private $referralOrder;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        if (!MovementType::isValid($type)) {
            throw new InvalidArgumentException("Invalid movement type");
        }
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    public function getAmountMoney()
    {
        return new Money(
            $this->getAmount(),
            new Currency($this->getCurrency())
        );
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
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
     * @return Wallet
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * @param Wallet $wallet
     */
    public function setWallet(Wallet $wallet)
    {
        $this->wallet = $wallet;
    }

    /**
     * @return Order
     */
    public function getReferralOrder()
    {
        return $this->referralOrder;
    }

    /**
     * @param Order $referralOrder
     */
    public function setReferralOrder(Order $referralOrder)
    {
        $this->referralOrder = $referralOrder;
    }
}
