<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Color;
use EventoOriginal\Core\Entities\ColorTranslation;
use EventoOriginal\Core\Persistence\Repositories\ColorRepository;
use Exception;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;

class ColorService
{
    private $colorRepository;
    private $translationRepository;

    public function __construct(
        ColorRepository $colorRepository,
        TranslationRepository $translationRepository
    ) {
        $this->colorRepository = $colorRepository;
        $this->translationRepository = $translationRepository;
    }

    public function findOneById(int $id)
    {
        $color = $this->colorRepository->findOneById($id);

        if (!$color) {
            throw new Exception("This color doesn't exist");
        }

        return $color;
    }

    public function findOneByName(string $name)
    {
        $color = $this->colorRepository->findOneByName($name);

        if (!$color) {
            throw new Exception("Doesn't exist a color with this name");
        }

        return $color;
    }

    public function findAll()
    {
        return $this->colorRepository->findAll();
    }

    public function create(string $name)
    {
        $color = new Color();
        $color->setName($name);

        $this->save($color);

        return $color;
    }

    public function addTranslation(Color $color, string $translatedName, string $locale)
    {
        $color->addTranslation(new ColorTranslation($locale, 'name', $translatedName));
        $this->save($color);
    }

    public function update(int $id, string $name)
    {
        $color = $this->findOneById($id);

        $color->setName($name);

        $this->save($color);

        return $color;
    }

    public function save(Color $color)
    {
        $this->colorRepository->save($color);
    }

    public function findOneInLocale(int $id, string $locale)
    {
        return $this->colorRepository->findOneInLocale($id, $locale);
    }
}
