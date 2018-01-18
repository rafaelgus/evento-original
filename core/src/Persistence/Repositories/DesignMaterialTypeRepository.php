<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\DesignMaterialType;

class DesignMaterialTypeRepository extends BaseRepository
{
    public function save(DesignMaterialType $designMaterialType, bool $flush = true)
    {
        $this->getEntityManager()->persist($designMaterialType);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneById(int $id)
    {
        return $this->find($id);
    }

    public function remove(DesignMaterialType $designMaterialType, bool $flush = true)
    {
        $this->getEntityManager()->remove($designMaterialType);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
