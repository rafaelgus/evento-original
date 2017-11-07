<?php

namespace EventoOriginal\Core\Entities;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\VisitorLandingRepository")
 * @ORM\Table(name="visitor_landings")
 */
class VisitorLanding
{
    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="visitorLanding")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="VisitorEvent", mappedBy="visitorLanding")
     */
    private $visitorEvents;

    public function __construct()
    {
        $this->visitorEvents = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function getVisitorEvents()
    {
        return $this->visitorEvents;
    }

    /**
     * @param mixed $visitorEvents
     */
    public function setVisitorEvents($visitorEvents)
    {
        $this->visitorEvents = $visitorEvents;
    }

    public function addVisitorEvent(VisitorEvent $visitorEvent)
    {
        $this->visitorEvents[] = $visitorEvent;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}
