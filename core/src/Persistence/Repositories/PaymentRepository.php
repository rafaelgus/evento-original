<?php
namespace EventoOriginal\Core\Persistence\Repositories;


use EventoOriginal\Core\Entities\Payment;

class PaymentRepository extends BaseRepository
{
    public function save(Payment $payment, bool $flush = true)
    {
        $this->getEntityManager()->persist($payment);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByToken(string $token)
    {
        return $this->findOneBy(['externalId' => $token]);
    }
}