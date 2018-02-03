<?php
namespace EventoOriginal\Core\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\DesignerRepository")
 * @ORM\Table(name="designers")
 */
class Designer
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
    private $nickname;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="designer")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(
     *   targetEntity="Design",
     *   mappedBy="designer",
     *   cascade={"persist", "remove"}
     * )
     */
    private $designs;

    public function __construct()
    {
        $this->designs = new ArrayCollection();
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
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname($nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getDesigns()
    {
        return $this->designs;
    }

    /**
     * @param array $designs
     */
    public function setDesigns(array $designs): void
    {
        $this->designs = $designs;
    }

    public function addDesign(Design $design): void
    {
        $this->designs[] = $design;
    }
}
