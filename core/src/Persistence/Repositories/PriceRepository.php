<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Price;

class PriceRepository extends BaseRepository
{
    public function save(Price $price, bool $flush = null)
    {
        $this->getEntityManager()->persist($price);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}