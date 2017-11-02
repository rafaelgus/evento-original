<?php
namespace EventoOriginal\Core\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\CustomerRepository")
 * @ORM\Table(name="customers")
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $websiteName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $websiteUrl;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $affiliateCode;

    /**
     * One Customer has One Cart.
     * @ORM\OneToOne(targetEntity="User", mappedBy="customer")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Address", mappedBy="customer")
     */
    private $addresses;

    /**
     * @ORM\Column(type="string")
     */
    private $phoneNumber;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
    }

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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getWebsiteName()
    {
        return $this->websiteName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @param string $websiteName
     */
    public function setWebsiteName(string $websiteName)
    {
        $this->websiteName = $websiteName;
    }

    /**
     * @return string
     */
    public function getWebsiteUrl()
    {
        return $this->websiteUrl;
    }

    /**
     * @param string $websiteUrl
     */
    public function setWebsiteUrl(string $websiteUrl)
    {
        $this->websiteUrl = $websiteUrl;
    }

    /**
     * @return string
     */
    public function getAffiliateCode()
    {
        return $this->affiliateCode;
    }

    /**
     * @param string $affiliateCode
     */
    public function setAffiliateCode(string $affiliateCode)
    {
        $this->affiliateCode = $affiliateCode;
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
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return ArrayCollection
     */
    public function getAddresses()
    {
        if (!$this->addresses) { $this->addresses = new ArrayCollection();}
        return $this->addresses->toArray();
    }

    /**
     * @param mixed $addresses
     */
    public function setAddresses(array $addresses)
    {
        $this->addresses = $addresses;
    }

    public function addAddress(Address $address)
    {
        $this->addresses[] = $address;
    }

}
