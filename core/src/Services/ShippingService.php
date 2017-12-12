<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Address;
use EventoOriginal\Core\Entities\Order;
use EventoOriginal\Core\Entities\Shipping;
use EventoOriginal\Core\Persistence\Repositories\ShippingRepository;

class ShippingService
{
    private $shippingRepository;

    public function __construct(ShippingRepository $shippingRepository)
    {
        $this->shippingRepository = $shippingRepository;
    }

    /**
     * @param Address $address
     * @param string $method
     * @return Shipping
     */
    public function create(Address $address, string $method)
    {
        $shipping = new Shipping();
        $shipping->setAddress($address);
        $shipping->setMethod($method);

        $this->shippingRepository->save($shipping);

        return $shipping;
    }

    /**
     * @param int $id
     * @return null|Shipping
     */
    public function findById(int $id)
    {
        return $this->shippingRepository->find($id);
    }
}