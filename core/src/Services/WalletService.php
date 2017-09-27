<?php

namespace EventoOriginal\Core\Services;

use DateTime;
use EventoOriginal\Core\Entities\Movement;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Entities\Wallet;
use EventoOriginal\Core\Persistence\Repositories\WalletRepository;
use Exception;
use Money\Money;

class WalletService
{
    private $walletRepository;
    private $movementService;

    public function __construct(
        WalletRepository $walletRepository,
        MovementService $movementService
    ) {
        $this->walletRepository = $walletRepository;
        $this->movementService = $movementService;
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

    public function addBalance(Wallet $wallet, $amount, string $movementType)
    {
        $movement = $this->movementService->create($wallet, $movementType, $amount, new DateTime());
        $wallet->addMovement($movement);

        $wallet->setBalance($wallet->getBalance() + $amount);

        $this->walletRepository->save($wallet);
    }
}
