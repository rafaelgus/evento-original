<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Persistence\Repositories\OccasionRepository;

class OccasionService
{
    /**
     * @var OccasionRepository
     */
    private $occasionRepository;

    public function __construct(
        OccasionRepository $occasionRepository
    ) {
        $this->occasionRepository = $occasionRepository;
    }

    public function findAll(string $locale)
    {
        return $this->occasionRepository->findAll($locale);
    }

    public function findOneById(int $id, string $locale)
    {
        return $this->occasionRepository->findOneById($id, $locale);
    }
}
