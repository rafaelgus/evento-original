<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Designer;

class DesignerRepository extends BaseRepository
{
    public function save(Designer $designer, bool $flush = true)
    {
        $this->getEntityManager()->persist($designer);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
