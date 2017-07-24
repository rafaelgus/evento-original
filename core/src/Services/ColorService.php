<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Color;
use EventoOriginal\Core\Entities\ColorTranslation;
use EventoOriginal\Core\Persistence\Repositories\ColorRepository;
use Exception;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;

class ColorService
{
    const DEFAULT_LOCALE = 'es';

    private $colorRepository;

    public function __construct(ColorRepository $colorRepository)
    {
        $this->colorRepository = $colorRepository;
    }

    public function findOneById(int $id, string $locale)
    {
        $color = $this->colorRepository->findOneById($id, $locale);

        if (!$color) {
            throw new Exception("This color doesn't exist");
        }

        return $color;
    }

    public function findOneByName(string $name, string $locale)
    {
        $color = $this->colorRepository->findOneByName($name, $locale);

        if (!$color) {
            throw new Exception("Doesn't exist a color with this name");
        }

        return $color;
    }

    public function findAll(string $locale)
    {
        return $this->colorRepository->findAll($locale);
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

    public function update(Color $color, string $name)
    {
        $color->setName($name);

        $this->save($color);

        return $color;
    }

    public function delete(Color $color)
    {
        $this->colorRepository->delete($color);
    }

    public function save(Color $color)
    {
        $this->colorRepository->save($color);
    }

    public function findByIds(array $ids)
    {
        $colors = [];

        foreach ($ids as $id) {
            $color = $this->colorRepository->findOneById($id, 'es');
            $colors[] = $color;
        }

        return $colors;
    }
}
