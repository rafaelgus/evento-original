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

    /**
     * @param int $id
     * @return null|Voucher
     */
    public function findById(int $id)
    {
        return $this->find($id);
    }

    /**
     * @param string $code
     * @return null|Voucher
     */
    public function findByCode(string $code)
    {
        return $this->findOneBy(['code' => $code]);
    }
}