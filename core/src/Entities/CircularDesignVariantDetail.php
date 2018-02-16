<?php
namespace EventoOriginal\Core\Entities;

use Doctrine\ORM\Mapping as ORM;
use Money\Currency;
use Money\Money;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\CircularDesignVariantDetailRepository")
 * @ORM\Table(name="circular_design_variant_details")
 */
class CircularDesignVariantDetail
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="CircularDesignVariant", inversedBy="details")
     * @ORM\JoinColumn(name="circular_design_variant_id", referencedColumnName="id")
     */
    private $circularDesignVariant;

    /**
     * @ORM\ManyToOne(targetEntity="DesignMaterialType")
     * @ORM\JoinColumn(name="design_material_type_id", referencedColumnName="id")
     */
    private $designMaterialType;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     */
    private $article;

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
    public function getCircularDesignVariant()
    {
        return $this->circularDesignVariant;
    }

    /**
     * @param mixed $circularDesignVariant
     */
    public function setCircularDesignVariant($circularDesignVariant)
    {
        $this->circularDesignVariant = $circularDesignVariant;
    }

    /**
     * @return DesignMaterialType
     */
    public function getDesignMaterialType()
    {
        return $this->designMaterialType;
    }

    /**
     * @param DesignMaterialType $designMaterialType
     */
    public function setDesignMaterialType(DesignMaterialType $designMaterialType)
    {
        $this->designMaterialType = $designMaterialType;
    }

    /**
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function getMoney()
    {
        return new Money($this->price, new Currency('EUR'));
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle(Article $article): void
    {
        $this->article = $article;
    }
}
