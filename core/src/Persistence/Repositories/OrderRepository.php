<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Order;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Entities\VisitorEvent;

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

    public function findAllByUser(User $user)
    {
        return $this->findBy(['user' => $user]);
    }
}
