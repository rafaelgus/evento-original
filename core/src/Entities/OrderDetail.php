<?php
namespace EventoOriginal\Core\Entities;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
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
     * @ManyToOne(targetEntity="Article", inversedBy="ordersDetail")
     * @JoinColumn(name="article_id", referencedColumnName="id")
     */
    private $article;
    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;
    /**
     * @ORM\Column(type="string")
     */
    private $currency;
    /**
     * @ORM\Column(type="integer")
     */
    private $amount;
    /**
     * @ManyToOne(targetEntity="Order", inversedBy="ordersDetail")
     * @JoinColumn(name="order_id", referencedColumnName="id")
     */
    private $order;
    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
        $money = new Money($this->amount, $this->currency);
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
}