<?php

namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Entities\Wallet;
use EventoOriginal\Core\Persistence\Repositories\WalletRepository;
use Exception;

class WalletService
{
    private $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function create(User $user)
    {
        if ($this->walletRepository->findByUser($user)) {
            throw new Exception("User already has a wallet");
        }

        $wallet = new Wallet();
        $wallet->setUser($user);

        return $this->walletRepository->save($wallet);
    }
}
