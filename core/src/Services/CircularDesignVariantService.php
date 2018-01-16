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
     * @var DesignMaterialSizeService
     */
    private $designMaterialSizeService;

    /**
     * CircularDesignVariantService constructor.
     * @param CircularDesignVariantRepository $circularDesignVariantRepository
     * @param DesignMaterialSizeService $designMaterialSizeService
     */
    public function __construct(
        CircularDesignVariantRepository $circularDesignVariantRepository,
        DesignMaterialSizeService $designMaterialSizeService
    ) {
        $this->circularDesignVariantRepository = $circularDesignVariantRepository;
        $this->designMaterialSizeService = $designMaterialSizeService;
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

        $designMaterialSize = $this->designMaterialSizeService->findOneById(
            array_get($data, 'design_material_size_id')
        );
        $circularDesignVariant->setDesignMaterialSize($designMaterialSize);

        if (array_has($data, 'preview_image')) {
            $circularDesignVariant->setPreviewImage(array_get($data, 'preview_image'));
        }

        $circularDesignVariant->setDiameterOfCircles(array_get($data, 'diameter_of_circles'));
        $circularDesignVariant->setNumberOfCircles(array_get($data, 'number_of_circles'));

        $this->circularDesignVariantRepository->save($circularDesignVariant);

        return $circularDesignVariant;
    }

    public function update(CircularDesignVariant $circularDesignVariant, array $data)
    {
        $circularDesignVariant->setName(array_get($data, 'name'));

        $designMaterialSize = $this->designMaterialSizeService->findOneById(
            array_get($data, 'design_material_size_id')
        );
        $circularDesignVariant->setDesignMaterialSize($designMaterialSize);

        if (array_has($data, 'preview_image')) {
            $circularDesignVariant->setPreviewImage(array_get($data, 'preview_image'));
        }

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
