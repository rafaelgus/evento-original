<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Order;

class OrderRepository extends BaseRepository
{
    public function save(Order $order, bool $flush = true)
    {
        $this->getEntityManager()->persist($order);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(int $id)
    {
        return $this->find($id);
    }
}
