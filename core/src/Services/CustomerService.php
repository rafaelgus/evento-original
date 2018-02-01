<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Customer;
use EventoOriginal\Core\Persistence\Repositories\CustomerRepository;
use Webpatser\Uuid\Uuid;
use EventoOriginal\Core\Entities\Country;

class CustomerService
{
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param array $data
     * @throws \Exception
     */
    public function create(array $data)
    {
        $customer = new Customer();
        $customer->setFirstName($data['first_name']);
        $customer->setLastName($data['last_name']);

        if (isset($data['website_name'])) {
            $customer->setWebsiteName($data['website_name']);
        }
        if (isset($data['website_url'])) {
            $customer->setWebsiteUrl($data['website_url']);
        }

        $customer->setAffiliateCode(Uuid::generate());
        $customer->setUser($data['user']);

        $this->customerRepository->save($customer);
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

    public function findOneByAffiliateCode(string $code)
    {
        return $this->customerRepository->findOneByAffiliateCode($code);
    }
}
