<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\DesignMaterialSize;

class DesignMaterialSizeRepository extends BaseRepository
{
    public function save(DesignMaterialSize $designMaterialSize, bool $flush = null)
    {
        $this->getEntityManager()->persist($designMaterialSize);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
