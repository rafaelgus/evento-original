<?php
namespace EventoOriginal\Core\Entities;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Money\Currency;
use Money\Money;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\OrderDetailRepository")
 * @ORM\Table(name="order_detail")
 */
class OrderDetail
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
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="orderDetails")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     */
    private $article;

    /**
     * @ORM\Column(type="string")
     */
    private $currency;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="ordersDetail", cascade={"persist"})
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    private $order;

    /**
     * @ORM\Column(type="boolean")
     */
    private $discount;

    /**
     * @ORM\ManyToOne(targetEntity="CircularDesignVariantDetail")
     * @ORM\JoinColumn(name="circular_design_variant_detail_id", referencedColumnName="id")
     */
    private $circularDesignVariantDetail;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @return Money
     */
    public function getMoney()
    {
        $money = new Money($this->amount, new Currency('EUR'));
        return $money;
    }

    /**
     * @param Money $money
     */
    public function setMoney(Money $money)
    {
        $this->amount = $money->getAmount();
        $this->currency = $money->getCurrency();
    }

    /**
     * @return bool
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param bool $discount
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
    }

    /**
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param Article $article
     */
    public function setArticle(Article $article)
    {
        $this->article = $article;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getCircularDesignVariantDetail()
    {
        return $this->circularDesignVariantDetail;
    }

    /**
     * @param mixed $circularDesignVariantDetail
     */
    public function setCircularDesignVariantDetail(CircularDesignVariantDetail $circularDesignVariantDetail): void
    {
        $this->circularDesignVariantDetail = $circularDesignVariantDetail;
    }
}
