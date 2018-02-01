<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\VisitorLanding;

class VisitorLandingRepository extends BaseRepository
{
    public function findOneById(int $id)
    {
        return $this->find($id);
    }

    public function save(VisitorLanding $visitorLanding, bool $flush = true)
    {
        $this->getEntityManager()->persist($visitorLanding);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
