<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\DesignMaterialType;
use EventoOriginal\Core\Persistence\Repositories\DesignMaterialTypeRepository;
use Exception;

class DesignMaterialTypeService
{
    /**
     * @var DesignMaterialTypeRepository
     */
    private $designMaterialTypeRepository;

    /**
     * DesignMaterialTypeService constructor.
     * @param DesignMaterialTypeRepository $designMaterialTypeRepository
     */
    public function __construct(DesignMaterialTypeRepository $designMaterialTypeRepository)
    {
        $this->designMaterialTypeRepository = $designMaterialTypeRepository;
    }

    public function findOneById(int $id)
    {
        return $this->designMaterialTypeRepository->findOneById($id);
    }

    public function findAll()
    {
        return $this->designMaterialTypeRepository->findAll();
    }

    public function create(array $data)
    {
        $designMaterialType = new DesignMaterialType();
        $designMaterialType->setName(array_get($data, 'name'));
        $designMaterialType->setDescription(array_get($data, 'description'));

        $this->designMaterialTypeRepository->save($designMaterialType);

        return $designMaterialType;
    }

    public function update(DesignMaterialType $designMaterialType, array $data)
    {
        $designMaterialType->setName(array_get($data, 'name'));
        $designMaterialType->setDescription(array_get($data, 'description'));

        $this->designMaterialTypeRepository->save($designMaterialType);

        return $designMaterialType;
    }

    public function remove(int $id)
    {
        $designMaterialType = $this->designMaterialTypeRepository->findOneById($id);

        if (!$designMaterialType) {
            throw new Exception("Design material type not found");
        }

        return $this->designMaterialTypeRepository->remove($designMaterialType);
    }
}
