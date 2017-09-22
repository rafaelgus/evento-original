<?php
namespace EventoOriginal\Core\Entities;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use EventoOriginal\Core\Enums\MovementType;
use InvalidArgumentException;

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
     * @ORM\Column(type="decimal", precision=7, scale=2)
     */
    private $amount;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Wallet", inversedBy="movements")
     * @ORM\JoinColumn(name="wallet_id", referencedColumnName="id")
     */
    private $wallet;

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
        if (!in_array($type, MovementType::values())) {
            throw new InvalidArgumentException("Invalid type");
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
}
