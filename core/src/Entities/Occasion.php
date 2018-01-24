<?php
namespace EventoOriginal\Core\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\OccasionRepository")
 * @ORM\Table(name="occasions")
 * @Gedmo\TranslationEntity(class="EventoOriginal\Core\Entities\OccasionTranslation")
 */
class Occasion
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(
     *   targetEntity="AllergenTranslation",
     *   mappedBy="object",
     *   cascade={"persist", "remove"}
     * )
     */
    private $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @param mixed $translations
     */
    public function setTranslations($translations): void
    {
        $this->translations = $translations;
    }
}
