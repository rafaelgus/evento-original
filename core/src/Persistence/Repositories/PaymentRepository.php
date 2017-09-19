<?php
namespace EventoOriginal\Core\Persistence\Repositories;


use EventoOriginal\Core\Entities\Payment;

class PaymentRepository extends BaseRepository
{
    public function save(Payment $payment, bool $flush)
    {
        $this->getEntityManager()->persist($payment);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}