<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Payout;

class PayoutRepository extends BaseRepository
{
    public function save(Payout $payout, bool $flush = true)
    {
        $this->getEntityManager()->persist($payout);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByExternalId(string $externalId)
    {
        return $this->findOneBy(['externalId' => $externalId]);
    }
}
