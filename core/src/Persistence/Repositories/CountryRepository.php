<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Country;

class CountryRepository extends BaseRepository
{
    public function findOneById(int $id)
    {
        return $this->find($id);
    }

    public function save(Country $country, bool $flush = true)
    {
        $this->getEntityManager()->persist($country);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
