<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Address;

class AddressRepository extends BaseRepository
{
    public function save(Address $address, bool $flush = true)
    {
        $this->getEntityManager()->persist($address);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}