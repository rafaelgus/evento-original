<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Customer;

class CustomerRepository extends BaseRepository
{
    public function save(Customer $customer, bool $flush = true)
    {
        $this->getEntityManager()->persist($customer);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneByAffiliateCode(string $affiliateCode)
    {
        return $this->findOneBy(['affiliateCode' => $affiliateCode]);
    }
}
