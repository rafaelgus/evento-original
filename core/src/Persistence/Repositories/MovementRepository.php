<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Movement;

class MovementRepository extends BaseRepository
{
    public function save(Movement $movement, bool $flush = true)
    {
        $this->getEntityManager()->persist($movement);

        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $movement;
    }
}
