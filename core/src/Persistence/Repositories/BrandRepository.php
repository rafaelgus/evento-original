<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Brand;

class BrandRepository extends BaseRepository
{
    public function findOneById(int $id)
    {
        return $this->find($id);
    }

    public function save(Brand $brand, bool $flush = true)
    {
        $this->getEntityManager()->persist($brand);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(Brand $brand, bool $flush = true)
    {
        $this->getEntityManager()->remove($brand);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
