<?php
namespace EventoOriginal\Core\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity(repositoryClass="EventoOriginal\Core\Persistence\Repositories\CategoryRepository")
 * @ORM\Table(name="categories")
 * @Gedmo\TranslationEntity(class="EventoOriginal\Core\Entities\CategoryTranslation")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(
     *   targetEntity="CategoryTranslation",
     *   mappedBy="object",
     *   cascade={"persist", "remove"}
     * )
     */
    private $translations;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $level;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="tree_root", referencedColumnName="id", onDelete="CASCADE")
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * @ORM\OneToMany(targetEntity="Voucher", mappedBy="category")
     */
    private $vouchers;

    /**
     * @ORM\Column(name="affiliate_commission", type="integer")
     */
    private $affiliateCommission;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
        $this->vouchers = new ArrayCollection();
        $this->children = new ArrayCollection();
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
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getDescription()
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

    public function getTranslations()
    {
        return $this->translations;
    }

    public function addTranslation(CategoryTranslation $t)
    {
        if (!$this->translations->contains($t)) {
            $this->translations[] = $t;
            $t->setObject($this);
        }
    }

    /**
     * @return integer
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return integer
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * @return integer
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Category $parent
     */
    public function setParent(Category $parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return ArrayCollection
     */
    public function getVouchers()
    {
        return $this->vouchers;
    }

    /**
     * @param array $vouchers
     */
    public function setVouchers(array $vouchers)
    {
        $this->vouchers = $vouchers;
    }

    /**
     * @param Voucher $voucher
     */
    public function addVoucher(Voucher $voucher)
    {
        $this->vouchers[] = $voucher;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function setChildren(array $children)
    {
        $this->children = $children;
    }

    public function addChild(array $child)
    {
        $this->children[] = $child;
    }

    /**
     * @return int Commission percentage for affiliates
     */
    public function getAffiliateCommission()
    {
        return $this->affiliateCommission;
    }

    /**
     * @param int $affiliateCommission
     */
    public function setAffiliateCommission(int $affiliateCommission)
    {
        $this->affiliateCommission = $affiliateCommission;
    }
}
