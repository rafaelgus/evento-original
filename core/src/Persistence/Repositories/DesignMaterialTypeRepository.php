<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\DesignMaterialType;

class DesignMaterialTypeRepository extends BaseRepository
{
    public function save(DesignMaterialType $designMaterialType, bool $flush = null)
    {
        $this->getEntityManager()->persist($designMaterialType);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
