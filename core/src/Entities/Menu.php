<?php
namespace EventoOriginal\Core\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\MenuRepository")
 * @ORM\Table(name="menus")
 */
class Menu
{
    public static $availableTypes = [
        'navbar',
        'home'
    ];

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @ORM\OneToMany(
     *   targetEntity="MenuItem",
     *   mappedBy="menu"
     * )
     */
    private $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
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
    public function getName()
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
        if (array_key_exists($type, self::$availableTypes)) {
            $this->type = $type;
        } else {
            throw new InvalidArgumentException("Invalid menu type");
        }
    }

    public function addItem(MenuItem $menuItem)
    {
        $this->items[] = $menuItem;
    }

    public function setItems(array $menuItems)
    {
        $this->items = $menuItems;
    }

    public function getItems()
    {
        return $this->items;
    }
}
