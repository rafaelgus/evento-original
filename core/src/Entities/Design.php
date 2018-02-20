<?php
namespace EventoOriginal\Core\Entities;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use EventoOriginal\Core\Enums\DesignOrientation;
use EventoOriginal\Core\Enums\DesignStatus;
use Exception;
use InvalidArgumentException;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\DesignRepository")
 * @ORM\Table(name="designs")
 */
class Design
{
    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Designer", inversedBy="designs", fetch="EAGER")
     * @ORM\JoinColumn(name="designer_id", referencedColumnName="id", nullable=true)
     */
    private $designer;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $json;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $previewImage;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $orientation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $commission;

    /**
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity="Occasion")
     * @ORM\JoinTable(name="design_occasions",
     *      joinColumns={@ORM\JoinColumn(name="design_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="occasion_id", referencedColumnName="id")}
     *      )
     */
    private $occasions;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $source;

    /**
     * @ORM\ManyToOne(targetEntity="CircularDesignVariant", fetch="EAGER")
     * @ORM\JoinColumn(name="circular_design_variant", referencedColumnName="id", nullable=true)
     */
    private $circularDesignVariant;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observation;

    /**
     * @ORM\OneToOne(targetEntity="Article", mappedBy="design")
     */
    private $article;

    public function __construct()
    {
        $this->status = DesignStatus::CREATED;
        $this->occasions = new ArrayCollection();
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
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return Designer
     */
    public function getDesigner()
    {
        return $this->designer;
    }

    /**
     * @param Designer $designer
     */
    public function setDesigner(Designer $designer): void
    {
        $this->designer = $designer;
    }

    /**
     * @return mixed
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * @param mixed $json
     */
    public function setJson($json): void
    {
        $this->json = $json;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
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
    public function getOrientation()
    {
        return $this->orientation;
    }

    /**
     * @param mixed $orientation
     * @throws Exception
     */
    public function setOrientation($orientation)
    {
        if (!DesignOrientation::isValid($orientation)) {
            throw new Exception("Invalid orientation");
        }

        $this->orientation = $orientation;
    }

    /**
     * @return mixed
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * @param mixed $commission
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus(string $status): void
    {
        if (!DesignStatus::isValid($status)) {
            throw new InvalidArgumentException("Invalid design status");
        }

        $this->status = $status;
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

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;
    }

    public function getOccasions()
    {
        return $this->occasions;
    }

    public function setOccasions(array $occasions)
    {
        $this->occasions = $occasions;
    }

    public function addOccasion(Occasion $occasion)
    {
        $this->occasions[] = $occasion;
    }

    /**
     * @return string|null
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource(string $source)
    {
        $this->source = $source;
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
    public function setCircularDesignVariant($circularDesignVariant): void
    {
        $this->circularDesignVariant = $circularDesignVariant;
    }

    /**
     * @return mixed
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * @param mixed $observation
     */
    public function setObservation($observation): void
    {
        $this->observation = $observation;
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
    public function setArticle($article): void
    {
        $this->article = $article;
    }
}
