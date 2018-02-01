<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Entities\Wallet;

class WalletRepository extends BaseRepository
{
    public function save(Wallet $wallet, bool $flush = true)
    {
        $this->getEntityManager()->persist($wallet);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByUser(User $user)
    {
        return $this->findBy(['user' => $user->getId()]);
    }
}
