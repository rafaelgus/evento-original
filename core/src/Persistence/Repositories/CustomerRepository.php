<?php
namespace EventoOriginal\Core\Persistence\Repositories;

class CustomerRepository extends BaseRepository
{
    public function save(Customer $customer, bool $flush = true)
    {
        $this->getEntityManager()->persist($customer);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}