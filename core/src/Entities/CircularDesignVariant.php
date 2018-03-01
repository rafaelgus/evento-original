<?php
namespace EventoOriginal\Core\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Money\Currency;
use Money\Money;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\CircularDesignVariantRepository")
 * @ORM\Table(name="circular_design_variants")
 */
class CircularDesignVariant
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
     * @ORM\ManyToOne(targetEntity="DesignMaterialSize")
     * @ORM\JoinColumn(name="design_material_size_id", referencedColumnName="id")
     */
    private $designMaterialSize;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberOfCircles;

    /**
     * @ORM\Column(type="float")
     */
    private $diameterOfCircles;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $previewImage;

    /**
     * @ORM\OneToMany(
     *     targetEntity="CircularDesignVariantDetail",
     *     mappedBy="circularDesignVariant",
     *     cascade={"persist", "remove"},
     *     fetch="EAGER"
     *     )
     */
    private $details;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=true)
     */
    private $category;

    /**
     * CircularDesignVariant constructor.
     */
    public function __construct()
    {
        $this->details = new ArrayCollection();
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
    public function getDesignMaterialSize()
    {
        return $this->designMaterialSize;
    }

    /**
     * @param mixed $designMaterialSize
     */
    public function setDesignMaterialSize($designMaterialSize): void
    {
        $this->designMaterialSize = $designMaterialSize;
    }

    /**
     * @return mixed
     */
    public function getNumberOfCircles()
    {
        return $this->numberOfCircles;
    }

    /**
     * @param mixed $numberOfCircles
     */
    public function setNumberOfCircles($numberOfCircles): void
    {
        $this->numberOfCircles = $numberOfCircles;
    }

    /**
     * @return mixed
     */
    public function getDiameterOfCircles()
    {
        return $this->diameterOfCircles;
    }

    /**
     * @param mixed $diameterOfCircles
     */
    public function setDiameterOfCircles($diameterOfCircles): void
    {
        $this->diameterOfCircles = $diameterOfCircles;
    }

    /**
     * @return mixed
     */
    public function getPreviewImage()
    {
        return $this->previewImage;
    }

    /**
     * @param mixed $previewImage
     */
    public function setPreviewImage($previewImage): void
    {
        $this->previewImage = $previewImage;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param mixed $details
     */
    public function setDetails($details): void
    {
        $this->details = $details;
    }

    public function addDetail(CircularDesignVariantDetail $circularDesignVariantDetail)
    {
        $this->details[] = $circularDesignVariantDetail;
    }

    public function getDefaultDetail()
    {
        if (count($this->details) > 0) {
            return $this->details[0];
        }

        return null;
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->price = $price;
    }

    public function getMoney()
    {
        return new Money($this->getPrice(), new Currency('EUR'));
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }
}
