<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Occasion;
use EventoOriginal\Core\Entities\OccasionTranslation;
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

    public function findOneById(int $id, string $locale = 'ES')
    {
        return $this->occasionRepository->findOneById($id, $locale);
    }

    public function create(array $data)
    {
        $occasion = new Occasion();
        $occasion->setName(array_get($data, 'name'));
        $occasion->setDescription(array_get($data, 'description'));

        if (isset($data['occasion_id'])) {
            $parent = $this->findOneById(array_get($data, 'occasion_id'));

            if ($parent) {
                $occasion->setParent($parent);
            }
        }

        return $this->occasionRepository->save($occasion);
    }

    public function update(Occasion $occasion, array $data)
    {
        $occasion->setName(array_get($data, 'name'));
        $occasion->setDescription(array_get($data, 'description'));

        if (isset($data['occasion_id'])) {
            $parent = $this->findOneById(array_get($data, 'occasion_id'));

            if ($parent) {
                $occasion->setParent($parent);
            }
        } else {
            $occasion->setParent(null);
        }

        return $this->occasionRepository->save($occasion);
    }

    public function addTranslation(
        Occasion $occasion,
        string $translatedName,
        string $translatedDescription,
        string $locale
    ) {
        $occasion->addTranslation(new OccasionTranslation($locale, 'name', $translatedName));
        $this->save($flavour);
    }
}
