<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Customer;

class CustomerRepository extends BaseRepository
{
    public function save(Customer $customer)
    {
        return $this->save($customer);
    }
}
