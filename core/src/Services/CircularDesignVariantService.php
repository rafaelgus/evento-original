<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\CircularDesignVariant;
use EventoOriginal\Core\Entities\CircularDesignVariantDetail;
use EventoOriginal\Core\Persistence\Repositories\CircularDesignVariantDetailRepository;
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
     * @var DesignMaterialTypeService
     */
    private $designMaterialTypeService;
    /**
     * @var CircularDesignVariantDetailRepository
     */
    private $circularDesignVariantDetailRepository;

    /**
     * CircularDesignVariantService constructor.
     * @param CircularDesignVariantRepository $circularDesignVariantRepository
     * @param CircularDesignVariantDetailRepository $circularDesignVariantDetailRepository
     * @param DesignMaterialSizeService $designMaterialSizeService
     * @param DesignMaterialTypeService $designMaterialTypeService
     */
    public function __construct(
        CircularDesignVariantRepository $circularDesignVariantRepository,
        CircularDesignVariantDetailRepository $circularDesignVariantDetailRepository,
        DesignMaterialSizeService $designMaterialSizeService,
        DesignMaterialTypeService $designMaterialTypeService
    ) {
        $this->circularDesignVariantRepository = $circularDesignVariantRepository;
        $this->designMaterialSizeService = $designMaterialSizeService;
        $this->designMaterialTypeService = $designMaterialTypeService;
        $this->circularDesignVariantDetailRepository = $circularDesignVariantDetailRepository;
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

        foreach ($data['material_types'] as $i => $design_material_type_id) {
            $designMaterialType = $this->designMaterialTypeService->findOneById($design_material_type_id);
            if ($designMaterialType) {
                $detail = new CircularDesignVariantDetail();
                $detail->setPrice($data['prices'][$i] * 100);
                $detail->setDesignMaterialType($designMaterialType);
                $detail->setCircularDesignVariant($circularDesignVariant);

                $circularDesignVariant->addDetail($detail);
            }
        }

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

        foreach ($circularDesignVariant->getDetails() as $detail) {
            $this->circularDesignVariantDetailRepository->remove($detail);
        }

        foreach ($data['material_types'] as $i => $design_material_type_id) {
            $designMaterialType = $this->designMaterialTypeService->findOneById($design_material_type_id);
            if ($designMaterialType) {
                $detail = new CircularDesignVariantDetail();
                $detail->setPrice($data['prices'][$i] * 100);
                $detail->setDesignMaterialType($designMaterialType);
                $detail->setCircularDesignVariant($circularDesignVariant);

                $circularDesignVariant->addDetail($detail);
            }
        }

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
