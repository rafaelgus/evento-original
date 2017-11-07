<?php
namespace EventoOriginal\Core\Entities;

use DateTime;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\VisitorEventRepository")
 * @ORM\Table(name="visitor_events")
 */
class VisitorEvent
{
    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="VisitorLanding", inversedBy="visitorEvents")
     * @ORM\JoinColumn(name="visitor_landing_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $visitorLanding;

    /**
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id", nullable=true)
     */
    private $article;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", name="user_agent", nullable=true)
     */
    private $userAgent;

    /**
     * @ORM\Column(type="string", name="affiliate_code_referral", nullable=true)
     */
    private $affiliateCodeReferral;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $ip;

    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getVisitorLanding()
    {
        return $this->visitorLanding;
    }

    /**
     * @param mixed $visitorLanding
     */
    public function setVisitorLanding($visitorLanding)
    {
        $this->visitorLanding = $visitorLanding;
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
    public function setArticle($article)
    {
        $this->article = $article;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @param mixed $userAgent
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    /**
     * @return mixed
     */
    public function getAffiliateCodeReferral()
    {
        return $this->affiliateCodeReferral;
    }

    /**
     * @param mixed $affiliateCodeReferral
     */
    public function setAffiliateCodeReferral($affiliateCodeReferral)
    {
        $this->affiliateCodeReferral = $affiliateCodeReferral;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     */
    public function setIp(string $ip)
    {
        $this->ip = $ip;
    }
}
