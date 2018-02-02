<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\CurrencyConversion;

class CurrencyConversionRepository extends BaseRepository
{
    public function findOneById(int $id)
    {
        return $this->find($id);
    }

    public function save(CurrencyConversion $currencyConversion, bool $flush = true)
    {
        $this->getEntityManager()->persist($currencyConversion);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(CurrencyConversion $currencyConversion, bool $flush = true)
    {
        $this->getEntityManager()->remove($currencyConversion);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
