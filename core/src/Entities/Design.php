<?php
namespace EventoOriginal\Core\Entities;

use Doctrine\ORM\Mapping as ORM;
use EventoOriginal\Core\Enums\DesignOrientation;
use Exception;

/**
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\DesignRepository")
 * @ORM\Table(name="designs")
 */
class Design
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Designer", inversedBy="designs")
     * @ORM\JoinColumn(name="designer_id", referencedColumnName="id")
     */
    private $designer;

    /**
     * @ORM\Column(type="json", nullable=true)
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
}
