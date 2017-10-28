<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Billing;

class BillingRepository extends BaseRepository
{
    public function save(Billing $billing, bool $flush = true)
    {
        $this->getEntityManager()->persist($billing);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}