<?php
namespace EventoOriginal\Core\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use EventoOriginal\Core\Enums\RoleType;
use EventoOriginal\Core\Infrastructure\Payments\Interfaces\PayerInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\UserRepository")
 * @ORM\Table(name="users")
 */
class User implements Authenticatable, CanResetPassword, PayerInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $password;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
     */
    protected $roles;

    /**
     * @ORM\Column(type="string", length=100, name="remember_token", nullable=true)
     */
    protected $rememberToken;

    /**
     * @ORM\OneToOne(targetEntity="Designer", mappedBy="user")
     */
    private $designer;

    /**
     * @ORM\OneToOne(targetEntity="Customer", mappedBy="user")
     */
    protected $customer;

    /**
     * @ORM\OneToOne(targetEntity="Wallet", mappedBy="user")
     */
    private $wallet;

    /**
     * @ORM\OneToOne(targetEntity="VisitorLanding", mappedBy="user")
     */
    private $visitorLanding;

    private $clientId;
    private $clientSecret;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return ArrayCollection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * @param Role $role
     */
    public function addRole(Role $role)
    {
        $this->roles[] = $role;
    }

    /**
     * @return mixed
     */
    public function getDesigner()
    {
        return $this->designer;
    }

    /**
     * @param Designer $designer
     */
    public function setDesigner(Designer $designer): void
    {
        $this->designer = $designer;
    }

    /**
     * @return string
     */
    public function getRememberToken(): string
    {
        return $this->rememberToken;
    }

    /**
     * @param string $rememberToken
     */
    public function setRememberToken($rememberToken)
    {
        $this->rememberToken = $rememberToken;
    }

    /**
     * Get the column value for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->email;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        // TODO: Implement sendPasswordResetNotification() method.
    }

    public function isAdmin()
    {
        foreach ($this->roles as $role) {
            if ($role->getName() === RoleType::ADMIN) {
                return true;
            }
        }

        return false;
    }

    public function isDesigner()
    {
        foreach ($this->roles as $role) {
            if ($role->getName() === RoleType::DESIGNER) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return Wallet
     */
    public function getWallet()
    {
        return $this->wallet;
    }

    /**
     * @param Wallet  $wallet
     */
    public function setWallet(Wallet $wallet)
    {
        $this->wallet = $wallet;
    }

    /**
     * @return VisitorLanding
     */
    public function getVisitorLanding()
    {
        return $this->visitorLanding;
    }

    /**
     * @param VisitorLanding $visitorLanding
     */
    public function setVisitorLanding(VisitorLanding $visitorLanding)
    {
        $this->visitorLanding = $visitorLanding;
    }

    public function getPhone()
    {
        // TODO: Implement getPhone() method.
    }

    public function getIdentification()
    {
        // TODO: Implement getIdentification() method.
    }
}
