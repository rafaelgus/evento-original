<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Allergen;
use EventoOriginal\Core\Entities\AllergenTranslation;
use EventoOriginal\Core\Persistence\Repositories\AllergenRepository;
use Exception;

class AllergenService
{
    private $allergenRepository;

    public function __construct(AllergenRepository $allergenRepository)
    {
        $this->allergenRepository = $allergenRepository;
    }

    public function findOneById(int $id, string $locale)
    {
        $allergen = $this->allergenRepository->findOneById($id, $locale);

        if (!$allergen) {
            throw new Exception("This allergen doesn't exist");
        }

        return $allergen;
    }

    public function findAll(string $locale)
    {
        return $this->allergenRepository->findAll($locale);
    }

    public function create(string $name)
    {
        $allergen = new Allergen();
        $allergen->setName($name);

        $this->save($allergen);

        return $allergen;
    }

    public function addTranslation(Allergen $allergen, string $translatedName, string $locale)
    {
        $allergen->addTranslation(new AllergenTranslation($locale, 'name', $translatedName));
        $this->save($allergen);
    }

    public function update(Allergen $allergen, string $name)
    {
        $allergen->setName($name);

        $this->save($allergen);

        return $allergen;
    }

    public function delete(Allergen $allergen)
    {
        $this->allergenRepository->delete($allergen);
    }

    public function save(Allergen $allergen)
    {
        $this->allergenRepository->save($allergen);
    }

    public function findByIds(array $ids)
    {
        $allergens = [];

        foreach ($ids as $id) {
            $allergen = $this->allergenRepository->findOneById($id, 'es');
            $allergens[] = $allergen;
        }

        return $allergens;
    }
}
