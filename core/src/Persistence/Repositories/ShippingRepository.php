<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Shipping;

class ShippingRepository extends BaseRepository
{
    public function save(Shipping $shipping, bool $flush = true)
    {
        $this->getEntityManager()->persist($shipping);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}