<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Address;
use EventoOriginal\Core\Entities\Country;
use EventoOriginal\Core\Entities\Customer;
use EventoOriginal\Core\Persistence\Repositories\AddressRepository;

class AddressService
{
    private $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function create(Customer $customer, Country $country, array $data)
    {
        $address = new Address();

        $address->setAddress($data['address']);
        $address->setCity($data['city']);
        $address->setPostalCode($data['postalCode']);
        $address->setProvince($data['state']);
        $address->setCustomer($customer);
        $address->setCountry($country);

        return $address;

    }

    public function findById(int $id)
    {
        return $this->addressRepository->find($id);
    }
}