<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Healthy;
use EventoOriginal\Core\Entities\HealthyTranslation;
use EventoOriginal\Core\Persistence\Repositories\HealthyRepository;
use Exception;

class HealthyService
{
    private $healthyRepository;

    public function __construct(HealthyRepository $flavourRepository)
    {
        $this->healthyRepository = $flavourRepository;
    }

    public function findOneById(int $id, string $locale)
    {
        $healthy = $this->healthyRepository->findOneById($id, $locale);

        if (!$healthy) {
            throw new Exception("This healthy doesn't exist");
        }

        return $healthy;
    }


    public function findAll(string $locale)
    {
        return $this->healthyRepository->findAll($locale);
    }

    public function create(string $name)
    {
        $healthy = new Healthy();
        $healthy->setName($name);

        $this->save($healthy);

        return $healthy;
    }

    public function addTranslation(Healthy $healthy, string $translatedName, string $locale)
    {
        $healthy->addTranslation(new HealthyTranslation($locale, 'name', $translatedName));
        $this->save($healthy);
    }

    public function update(Healthy $healthy, string $name)
    {
        $healthy->setName($name);

        $this->save($healthy);

        return $healthy;
    }

    public function delete(Healthy $healthy)
    {
        $this->healthyRepository->delete($healthy);
    }

    public function save(Healthy $healthy)
    {
        $this->healthyRepository->save($healthy);
    }

    public function findByIds(array $ids)
    {
        $healthys = [];

        foreach ($ids as $id) {
            $healthy = $this->healthyRepository->findOneById($id, 'es');
            $healthys[] = $healthy;
        }

        return $healthys;
    }

    public function getByCategories(array $categories, string $locale = 'es')
    {
        return $this->healthyRepository->getByCategories($categories, $locale);
    }
}
