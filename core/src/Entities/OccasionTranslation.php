<?php
namespace EventoOriginal\Core\Entities;

use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

class OccasionTranslation extends AbstractPersonalTranslation
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
     * @ORM\ManyToOne(targetEntity="Occasion", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;
}
