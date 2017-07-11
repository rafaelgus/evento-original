<?php
namespace EventoOriginal\Core\Entities;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\PriceRepository")
 * @ORM\Table(name="prices")
 */
class Price
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $gramme;

    /**
     * @ORM\Column(type="decimal")
     */
    private $priceCurrency;

    /**
     * @ORM\Column(type="decimal")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="pricePerQuantity")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     */
    private $article;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getGramme(): int
    {
        return $this->gramme;
    }

    /**
     * @param int $gramme
     */
    public function setGramme(int $gramme)
    {
        $this->gramme = $gramme;
    }

    /**
     * @return mixed
     */
    public function getPriceCurrency()
    {
        return $this->priceCurrency;
    }

    /**
     * @param mixed $priceCurrency
     */
    public function setPriceCurrency($priceCurrency)
    {
        $this->priceCurrency = $priceCurrency;
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
     * @return Article
     */
    public function getArticle(): Article
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle(Article $article)
    {
        $this->article = $article;
    }
}