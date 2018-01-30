<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Category;
use EventoOriginal\Core\Entities\Flavour;
use EventoOriginal\Core\Entities\FlavourTranslation;
use EventoOriginal\Core\Persistence\Repositories\FlavourRepository;
use Exception;

class FlavourService
{
    private $flavourRepository;

    public function __construct(FlavourRepository $flavourRepository)
    {
        $this->flavourRepository = $flavourRepository;
    }

    public function findOneById(int $id, string $locale)
    {
        $flavour = $this->flavourRepository->findOneById($id, $locale);

        if (!$flavour) {
            throw new Exception("This flavour doesn't exist");
        }

        return $flavour;
    }

    public function findOneByName(string $name, string $locale)
    {
        $flavour = $this->flavourRepository->findOneByName($name, $locale);

        if (!$flavour) {
            throw new Exception("Doesn't exist a flavour with this name");
        }

        return $flavour;
    }

    public function findAll(string $locale)
    {
        return $this->flavourRepository->findAll($locale);
    }

    public function create(string $name)
    {
        $flavour = new Flavour();
        $flavour->setName($name);

        $this->save($flavour);

        return $flavour;
    }

    public function addTranslation(Flavour $flavour, string $translatedName, string $locale)
    {
        $flavour->addTranslation(new FlavourTranslation($locale, 'name', $translatedName));
        $this->save($flavour);
    }

    public function update(Flavour $flavour, string $name)
    {
        $flavour->setName($name);

        $this->save($flavour);

        return $flavour;
    }

    public function delete(Flavour $flavour)
    {
        $this->flavourRepository->delete($flavour);
    }

    public function save(Flavour $flavour)
    {
        $this->flavourRepository->save($flavour);
    }

    public function findByIds(array $ids)
    {
        $flavours = [];

        foreach ($ids as $id) {
            $flavour = $this->flavourRepository->findOneById($id, 'es');
            $flavours[] = $flavour;
        }

        return $flavours;
    }

    public function getByCategories(array $categories, string $locale = 'es')
    {
        return $this->flavourRepository->getByCategories($categories, $locale);
    }
}
