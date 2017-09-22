<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Customer;
use EventoOriginal\Core\Persistence\Repositories\CustomerRepository;
use Webpatser\Uuid\Uuid;

class CustomerService
{
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

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
}
