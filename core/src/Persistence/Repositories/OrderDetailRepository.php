<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\OrderDetail;

class OrderDetailRepository extends BaseRepository
{
    public function save(OrderDetail $orderDetail, bool $flush = true)
    {
        $this->getEntityManager()->persist($orderDetail);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}