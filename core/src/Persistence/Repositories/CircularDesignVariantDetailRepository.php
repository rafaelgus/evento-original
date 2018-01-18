<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\CircularDesignVariantDetail;

class CircularDesignVariantDetailRepository extends BaseRepository
{
    public function save(CircularDesignVariantDetail $circularDesignVariantDetail, bool $flush = true)
    {
        $this->getEntityManager()->persist($circularDesignVariantDetail);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CircularDesignVariantDetail $circularDesignVariantDetail, bool $flush = true)
    {
        $this->getEntityManager()->remove($circularDesignVariantDetail);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
