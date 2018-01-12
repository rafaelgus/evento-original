<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\CircularDesignVariantDetail;

class CircularDesignVariantDetailRepository extends BaseRepository
{
    public function save(CircularDesignVariantDetail $circularDesignVariantDetail, bool $flush = null)
    {
        $this->getEntityManager()->persist($circularDesignVariantDetail);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
