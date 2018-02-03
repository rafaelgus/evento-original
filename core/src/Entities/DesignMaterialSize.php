<?php
namespace EventoOriginal\Core\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\DesignMaterialSizeRepository")
 * @ORM\Table(name="design_material_sizes")
 */
class DesignMaterialSize
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
    private $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $horizontalSize;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $verticalSize;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getHorizontalSize()
    {
        return $this->horizontalSize;
    }

    /**
     * @param mixed $horizontalSize
     */
    public function setHorizontalSize($horizontalSize): void
    {
        $this->horizontalSize = $horizontalSize;
    }

    /**
     * @return mixed
     */
    public function getVerticalSize()
    {
        return $this->verticalSize;
    }

    /**
     * @param mixed $verticalSize
     */
    public function setVerticalSize($verticalSize): void
    {
        $this->verticalSize = $verticalSize;
    }
}
