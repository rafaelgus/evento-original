<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\CircularDesignVariant;

class CircularDesignVariantRepository extends BaseRepository
{
    public function save(CircularDesignVariant $circularDesignVariant, bool $flush = null)
    {
        $this->getEntityManager()->persist($circularDesignVariant);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
