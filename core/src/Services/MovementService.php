<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Movement;
use EventoOriginal\Core\Entities\Order;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Entities\VisitorEvent;
use EventoOriginal\Core\Entities\Wallet;
use DateTime;
use EventoOriginal\Core\Persistence\Repositories\MovementRepository;
use Money\Money;

class MovementService
{
    private $movementRepository;

    public function __construct(MovementRepository $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    public function create(Wallet $wallet, string $type, Money $amount, DateTime $date, Order $referralOrder = null)
    {
        $movement = new Movement();
        $movement->setType($type);
        $movement->setAmount($amount->getAmount());
        $movement->setCurrency($amount->getCurrency());
        $movement->setDate($date);
        $movement->setWallet($wallet);
        $movement->setReferralOrder($referralOrder);

        return $this->movementRepository->save($movement);
    }

    public function getAllByUserPaginated(User $user, int $currentPage = 1, int $maxItems = 10)
    {
        return $this->movementRepository->findAllByUserPaginated($user, $currentPage, $maxItems);
    }

    public function findLastMovementsByUser(User $user, int $days)
    {
        return $this->movementRepository->findLastMovementsByUser($user, $days);
    }
}