<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\License;

class LicenseRepository extends BaseRepository
{
    public function save(License $license, bool $flush = true)
    {
        $this->getEntityManager()->persist($license);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(License $license, bool $flush = true)
    {
        $this->getEntityManager()->remove($license);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(int $id)
    {
        return $this->find($id);
    }
}