<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Design;
use EventoOriginal\Core\Entities\Order;
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

    public function flushRepository()
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @param Order $order
     * @param Design $design
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByOrderAndDesign(Order $order, Design $design)
    {
        $query = $this->createQueryBuilder('od')
            ->join('od.article', 'a', 'od.article = a.id')
            ->where('a.design = :design_id AND od.order = :order_id')
            ->setParameters([
                'design_id' => $design->getId(),
                'order_id' => $order->getId(),
            ])
            ->getQuery();

        return $query->getResult();
    }
}