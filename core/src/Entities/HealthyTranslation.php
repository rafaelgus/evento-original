<?php
namespace EventoOriginal\Core\Entities;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Gedmo\Translatable\Entity\Repository\TranslationRepository")
 * @ORM\Table(
 *     name="healthy_translations",
 *     uniqueConstraints={
 *          @ORM\UniqueConstraint(
 *              name="lookup_unique_idx",
 *              columns={"locale", "object_id", "field"}
 *          )
 *     }
 * )
 */
class HealthyTranslation extends AbstractPersonalTranslation
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
     * @ORM\ManyToOne(targetEntity="Healthy", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;
}
