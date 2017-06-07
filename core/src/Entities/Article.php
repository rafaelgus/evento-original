<?php
namespace EventoOriginal\Core\Entities;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\ArticleRepository")
 * @ORM\Table(name="articles")
 * @Gedmo\TranslationEntity(class="EventoOriginal\Core\Entities\ArticleTranslation")
 */
class Article
{
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_DISCONTINUED = 'discontinued';

    public static $allowedStatus = [self::STATUS_DRAFT, self::STATUS_PUBLISHED, self::STATUS_DISCONTINUED];

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
     * @Gedmo\Translatable
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string")
     */
    private $barCode;

    /**
     * @ORM\Column(type="string")
     */
    private $internalCode;

    /**
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @ORM\Column(type="decimal")
     */
    private $price;

    /**
     * @ORM\Column(type="string")
     */
    private $priceCurrency;

    /**
     * @ORM\ManyToOne(targetEntity="Tax")
     * @ORM\JoinColumn(name="tax_id", referencedColumnName="id")
     */
    private $tax;

    /**
     * @ORM\Column(type="decimal")
     */
    private $costPrice;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishedOn;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="text")
     */
    private $ingredients;

    /**
     * @ORM\ManyToOne(targetEntity="Brand", inversedBy="articles")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="articles")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="Tag")
     * @ORM\JoinTable(name="articles_tags",
     *      joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity="Color")
     * @ORM\JoinTable(name="articles_colors",
     *      joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="color_id", referencedColumnName="id")}
     *      )
     */
    private $colors;

    /**
     * @ORM\ManyToMany(targetEntity="Flavour")
     * @ORM\JoinTable(name="articles_flavours",
     *      joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="flavour_id", referencedColumnName="id")}
     *      )
     */
    private $flavours;

    /**
     * @ORM\ManyToMany(targetEntity="Allergen")
     * @ORM\JoinTable(name="articles_allergens",
     *      joinColumns={@ORM\JoinColumn(name="article_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="allergen_id", referencedColumnName="id")}
     *      )
     */
    private $allergens;

    /**
     * @ORM\OneToMany(
     *   targetEntity="ArticleTranslation",
     *   mappedBy="object",
     *   cascade={"persist", "remove"}
     * )
     */
    private $translations;

    public function __construct()
    {
        $this->status = self::STATUS_DRAFT;

        $this->tags = new ArrayCollection();
        $this->colors = new ArrayCollection();
        $this->flavours = new ArrayCollection();
        $this->allergens = new ArrayCollection();
        $this->translations = new ArrayCollection();
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

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getBarCode(): string
    {
        return $this->barCode;
    }

    /**
     * @param string $barCode
     */
    public function setBarCode(string $barCode)
    {
        $this->barCode = $barCode;
    }

    /**
     * @return string
     */
    public function getInternalCode(): string
    {
        return $this->internalCode;
    }

    /**
     * @param string $internalCode
     */
    public function setInternalCode(string $internalCode)
    {
        $this->internalCode = $internalCode;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        if (!in_array($status, static::$allowedStatus)) {
            throw new InvalidArgumentException('Not allowed status');
        }

        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getPriceCurrency(): string
    {
        return $this->priceCurrency;
    }

    /**
     * @param string $priceCurrency
     */
    public function setPriceCurrency(string $priceCurrency)
    {
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * @return mixed
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param Tax $tax
     */
    public function setTax(Tax $tax)
    {
        $this->tax = $tax;
    }

    /**
     * @return mixed
     */
    public function getCostPrice()
    {
        return $this->costPrice;
    }

    /**
     * @param mixed $costPrice
     */
    public function setCostPrice($costPrice)
    {
        $this->costPrice = $costPrice;
    }

    /**
     * @return DateTime
     */
    public function getPublishedOn()
    {
        return $this->publishedOn;
    }

    /**
     * @param DateTime $publishedOn
     */
    public function setPublishedOn(DateTime $publishedOn)
    {
        $this->publishedOn = $publishedOn;
    }

    /**
     * @return string
     */
    public function getIngredients(): string
    {
        return $this->ingredients;
    }

    /**
     * @param string $ingredients
     */
    public function setIngredients(string $ingredients)
    {
        $this->ingredients = $ingredients;
    }

    /**
     * @return Brand
     */
    public function getBrand(): Brand
    {
        return $this->brand;
    }

    /**
     * @param Brand $brand
     */
    public function setBrand(Brand $brand)
    {
        $this->brand = $brand;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;
    }

    /**
     * @return mixed
     */
    public function getColors()
    {
        return $this->colors;
    }

    /**
     * @param array $colors
     */
    public function setColors(array $colors)
    {
        $this->colors = $colors;
    }

    /**
     * @param Color $color
     */
    public function addColor(Color $color)
    {
        $this->colors[] = $color;
    }

    /**
     * @return mixed
     */
    public function getFlavours()
    {
        return $this->flavours;
    }

    /**
     * @param array $flavours
     */
    public function setFlavours(array $flavours)
    {
        $this->flavours = $flavours;
    }

    /**
     * @param Flavour $flavour
     */
    public function addFlavour(Flavour $flavour)
    {
        $this->flavours[] = $flavour;
    }

    /**
     * @return mixed
     */
    public function getAllergens()
    {
        return $this->allergens;
    }

    /**
     * @param array $allergens
     */
    public function setAllergens(array $allergens)
    {
        $this->allergens = $allergens;
    }

    /**
     * @param Allergen $allergen
     */
    public function addAllergen(Allergen $allergen)
    {
        $this->allergens[] = $allergen;
    }

    /**
     * @return mixed
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * @param ArticleTranslation $t
     */
    public function addTranslation(ArticleTranslation $t)
    {
        if (!$this->translations->contains($t)) {
            $this->translations[] = $t;
            $t->setObject($this);
        }
    }
}