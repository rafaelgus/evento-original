<?php
namespace EventoOriginal\Core\Services;

use DateTime;
use EventoOriginal\Core\Entities\Movement;
use EventoOriginal\Core\Entities\Order;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Entities\VisitorEvent;
use EventoOriginal\Core\Entities\Wallet;
use EventoOriginal\Core\Enums\MovementType;
use EventoOriginal\Core\Enums\PayoutStatus;
use EventoOriginal\Core\Persistence\Repositories\UserRepository;
use EventoOriginal\Core\Persistence\Repositories\WalletRepository;
use Exception;
use Money\Currency;
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

    public function addBalance(Wallet $wallet, Money $money, string $movementType, Order $referralOrder = null)
    {
        $movement = $this->movementService->create($wallet, $movementType, $money, new DateTime(), $referralOrder);
        $wallet->addMovement($movement);

        logger()->info($wallet->getBalance());

        $wallet->setBalance($wallet->getBalance() + $money->getAmount());

        $this->walletRepository->save($wallet);
    }

    public function liquidateUserBalance(User $user)
    {
        $wallet = $user->getWallet();

        if ($wallet && $wallet->getBalance() > 0) {
            $amount = $wallet->getBalanceMoney()->getAmount();

            $movementMoneyAmount = new Money(-$amount, $wallet->getBalanceMoney()->getCurrency());

            $this->movementService->create($wallet, MovementType::PAYOUT, $movementMoneyAmount, new DateTime());

            $payout = $this->payoutService->create($user, 'paypal', $amount);
            $wallet->setBalance(0);

//            try {
//                $this->payoutService->send($payout);
//            } catch (Exception $exception) {
//                throw new Exception("Error liquidating user balance: " . $user->getId() . " " .
//                    $exception->getMessage());
//            }

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
