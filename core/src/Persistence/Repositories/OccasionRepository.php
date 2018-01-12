<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Occasion;

class OccasionRepository extends BaseRepository
{
    public function save(Occasion $occasion, bool $flush = null)
    {
        $this->getEntityManager()->persist($occasion);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
