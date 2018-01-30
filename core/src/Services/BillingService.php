<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Address;
use EventoOriginal\Core\Entities\Billing;
use EventoOriginal\Core\Persistence\Repositories\BillingRepository;

class BillingService
{
    protected $billingRepository;

    public function __construct(BillingRepository $billingRepository)
    {
        $this->billingRepository = $billingRepository;
    }

    /**
     * @param array $data
     * @param Address $address
     * @return Billing
     */
    public function create(array $data, Address $address)
    {
        $billing = new Billing();

        $billing->setName($data['name']);
        $billing->setAddress($address);
        $billing->setLastName($data['lastName']);
        $billing->setCompany($data['company']);

        $this->billingRepository->save($billing);

        return $billing;
    }

    /**
     * @param int $id
     * @return null|Billing
     */
    public function findById(int $id)
    {
        return $this->billingRepository->find($id);
    }
}