<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Voucher;

class VoucherRepository extends BaseRepository
{
    public function save(Voucher $voucher, bool $flush = true)
    {
        $this->getEntityManager()->persist($voucher);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(int $id)
    {
        return $this->find($id);
    }

    public function findAll()
    {
        return $this->findAll();
    }

    public function findByCode(string $code)
    {
        return $this->findOneBy(['code' => $code]);
    }
}