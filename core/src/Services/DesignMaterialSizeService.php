<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\DesignMaterialSize;
use EventoOriginal\Core\Persistence\Repositories\DesignMaterialSizeRepository;
use Exception;

class DesignMaterialSizeService
{
    /**
     * @var DesignMaterialSizeRepository
     */
    private $designMaterialSizeRepository;

    /**
     * DesignMaterialSizeService constructor.
     * @param DesignMaterialSizeRepository $designMaterialSizeRepository
     */
    public function __construct(DesignMaterialSizeRepository $designMaterialSizeRepository)
    {
        $this->designMaterialSizeRepository = $designMaterialSizeRepository;
    }

    public function findOneById(int $id)
    {
        return $this->designMaterialSizeRepository->findOneById($id);
    }

    public function findAll()
    {
        return $this->designMaterialSizeRepository->findAll();
    }

    public function create(array $data)
    {
        $designMaterialSize = new DesignMaterialSize();
        $designMaterialSize->setName(array_get($data, 'name'));
        $designMaterialSize->setHorizontalSize(array_get($data, 'horizontal_size'));
        $designMaterialSize->setVerticalSize(array_get($data, 'vertical_size'));
        $designMaterialSize->setHorizontalSizeInPx(array_get($data, 'horizontal_size_in_px'));
        $designMaterialSize->setVerticalSizeInPx(array_get($data, 'vertical_size_in_px'));

        $this->designMaterialSizeRepository->save($designMaterialSize);

        return $designMaterialSize;
    }

    public function update(DesignMaterialSize $designMaterialSize, array $data)
    {
        $designMaterialSize->setName(array_get($data, 'name'));
        $designMaterialSize->setHorizontalSize(array_get($data, 'horizontal_size'));
        $designMaterialSize->setVerticalSize(array_get($data, 'vertical_size'));
        $designMaterialSize->setHorizontalSizeInPx(array_get($data, 'horizontal_size_in_px'));
        $designMaterialSize->setVerticalSizeInPx(array_get($data, 'vertical_size_in_px'));

        $this->designMaterialSizeRepository->save($designMaterialSize);

        return $designMaterialSize;
    }

    public function remove(int $id)
    {
        $designMaterialSize = $this->designMaterialSizeRepository->findOneById($id);

        if (!$designMaterialSize) {
            throw new Exception("Design material size not found");
        }

        return $this->designMaterialSizeRepository->remove($designMaterialSize);
    }
}
