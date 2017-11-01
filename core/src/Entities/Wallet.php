<?php
namespace EventoOriginal\Core\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Money\Currency;
use Money\Money;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\WalletRepository")
 * @ORM\Table(name="wallets")
 */
class Wallet
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="wallet", orphanRemoval=true)
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $balance;

    /**
     * @ORM\OneToMany(targetEntity="Movement", mappedBy="wallet")
     */
    private $movements;

    public function __construct()
    {
        $this->movements = new ArrayCollection();
        $this->balance = 0;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return mixed
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param mixed $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }

    /**
     * @return mixed
     */
    public function getMovements()
    {
        return $this->movements;
    }

    /**
     * @param array $movements
     */
    public function setMovements(array $movements)
    {
        $this->movements = $movements;
    }

    /**
     * @param Movement $movement
     */
    public function addMovement(Movement $movement)
    {
        $this->movements[] = $movement;
    }

    /**
     * @return Money $balance
     */
    public function getBalanceMoney()
    {
        return new Money(
            $this->getBalance(),
            new Currency('EUR')
        );
    }
}
