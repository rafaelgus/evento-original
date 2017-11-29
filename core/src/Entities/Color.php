<?php
namespace EventoOriginal\Core\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\ColorRepository")
 * @ORM\Table(name="colors")
 * @Gedmo\TranslationEntity(class="EventoOriginal\Core\Entities\ColorTranslation")
 */
class Color
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255)
     */
    private $name;


    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $hexadecimalCode;

    /**
     * @ORM\OneToMany(
     *   targetEntity="ColorTranslation",
     *   mappedBy="object",
     *   cascade={"persist", "remove"}
     * )
     */
    private $translations;

    /**
     * @ORM\ManyToMany(targetEntity="Article", mappedBy="colors")
     */
    private $articles;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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

    public function getTranslations()
    {
        return $this->translations;
    }

    public function addTranslation(ColorTranslation $t)
    {
        if (!$this->translations->contains($t)) {
            $this->translations[] = $t;
            $t->setObject($this);
        }
    }

    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param mixed $articles
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;
    }

    /**
     * @return string
     */
    public function getHexadecimalCode()
    {
        return $this->hexadecimalCode;
    }

    /**
     * @param string $hexadecimalCode
     */
    public function setHexadecimalCode(string $hexadecimalCode)
    {
        $this->hexadecimalCode = $hexadecimalCode;
    }
}
