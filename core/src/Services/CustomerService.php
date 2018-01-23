<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Country;
use EventoOriginal\Core\Entities\Customer;
use EventoOriginal\Core\Persistence\Repositories\CustomerRepository;

class CustomerService
{
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function updateCheckoutInformation(Customer $customer, array $data)
    {
        $customer->setBillingAddress($data['billingAddress']. ' ' .$data['billingAddressNumber']);
        $customer->setAddress($data['address']. ' ' . $data['addressNumber']);
        $customer->setPhoneNumber($data['phone']);

        $this->customerRepository->save($customer);
    }

    /**
     * @param int $id
     * @return null|Country
     */
    public function findById(int $id)
    {
        return $this->customerRepository->find($id);
    }
}