<?php

namespace EventoOriginal\Core\Services;

use DateTime;
use EventoOriginal\Core\Entities\Movement;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Entities\Wallet;
use EventoOriginal\Core\Persistence\Repositories\UserRepository;
use EventoOriginal\Core\Persistence\Repositories\WalletRepository;
use Exception;
use Money\Money;

class WalletService
{
    private $walletRepository;
    private $movementService;
    private $payoutService;
    private $userRepository;

    public function __construct(
        WalletRepository $walletRepository,
        MovementService $movementService,
        PayoutService $payoutService,
        UserRepository $userRepository
    ) {
        $this->walletRepository = $walletRepository;
        $this->movementService = $movementService;
        $this->payoutService = $payoutService;
        $this->userRepository = $userRepository;
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

    public function liquidateUserBalance(User $user)
    {
        $wallet = $user->getWallet();

        $amount = ($wallet ? $wallet->getBalanceMoney()->getAmount() : 0);

        if ($amount > 0) {
            $payout = $this->payoutService->create($user, 'paypal', $amount);

            try {
                $this->payoutService->send($payout);
            } catch (Exception $exception) {
                throw new Exception("Error liquidating user balance: " . $user->getId() . " " .
                    $exception->getMessage());
            }

            $wallet->setBalance(0);

            $this->walletRepository->save($wallet);
        }
    }

    public function liquidateAllUsersBalance()
    {
        $users = $this->userRepository->findAll();

        foreach ($users as $user) {
            try {
                $this->liquidateUserBalance($user);
            } catch (Exception $exception) {
                logger()->error($exception->getMessage());
            }
        }
    }
}
