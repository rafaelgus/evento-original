<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\DesignMaterialSize;

class DesignMaterialSizeRepository extends BaseRepository
{
    public function save(DesignMaterialSize $designMaterialSize, bool $flush = true)
    {
        $this->getEntityManager()->persist($designMaterialSize);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneById(int $id)
    {
        return $this->find($id);
    }

    public function remove(DesignMaterialSize $designMaterialSize, bool $flush = true)
    {
        $this->getEntityManager()->remove($designMaterialSize);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
