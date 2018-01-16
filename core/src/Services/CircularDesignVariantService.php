<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\CircularDesignVariant;
use EventoOriginal\Core\Persistence\Repositories\CircularDesignVariantRepository;
use Exception;

class CircularDesignVariantService
{
    /**
     * @var CircularDesignVariantRepository
     */
    private $circularDesignVariantRepository;

    /**
     * CircularDesignVariantService constructor.
     * @param CircularDesignVariantRepository $circularDesignVariantRepository
     */
    public function __construct(CircularDesignVariantRepository $circularDesignVariantRepository)
    {
        $this->circularDesignVariantRepository = $circularDesignVariantRepository;
    }

    public function findOneById(int $id)
    {
        return $this->circularDesignVariantRepository->findOneById($id);
    }

    public function findAll()
    {
        return $this->circularDesignVariantRepository->findAll();
    }

    public function create(array $data)
    {
        $circularDesignVariant = new CircularDesignVariant();
        $circularDesignVariant->setName(array_get($data, 'name'));
        //TODO: faltan atributos

        $circularDesignVariant->setDiameterOfCircles(array_get($data, 'diameter_of_circles'));
        $circularDesignVariant->setNumberOfCircles(array_get($data, 'number_of_circles'));

        $this->circularDesignVariantRepository->save($circularDesignVariant);

        return $circularDesignVariant;
    }

    public function update(CircularDesignVariant $circularDesignVariant, array $data)
    {
        $circularDesignVariant->setName(array_get($data, 'name'));
        $circularDesignVariant->setDiameterOfCircles(array_get($data, 'diameter_of_circles'));
        $circularDesignVariant->setNumberOfCircles(array_get($data, 'number_of_circles'));

        $this->circularDesignVariantRepository->save($circularDesignVariant);

        return $circularDesignVariant;
    }

    public function remove(int $id)
    {
        $circularDesignVariant = $this->circularDesignVariantRepository->findOneById($id);

        if (!$circularDesignVariant) {
            throw new Exception("Design material size not found");
        }

        return $this->circularDesignVariantRepository->remove($circularDesignVariant);
    }
}
