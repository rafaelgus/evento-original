<?php
namespace EventoOriginal\Core\Entities;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 * @ORM\Table(
 *     name="article_translations",
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(
 *              name="lookup_unique_idx",
 *              columns={"locale", "object_id", "field"}
 *          )
 *     }
 * )
 */
class ArticleTranslation extends AbstractPersonalTranslation
{
    /**
     * @param string $locale
     * @param string $field
     * @param string $value
     */
    public function __construct($locale, $field, $value)
    {
        $this->setLocale($locale);
        $this->setField($field);
        $this->setContent($value);
    }

    /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;
}
