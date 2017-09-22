<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Movement;
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

    public function create(Wallet $wallet, string $type, Money $amountMoney, DateTime $date)
    {
        $movement = new Movement();
        $movement->setType($type);
        $movement->setAmount($amountMoney->getAmount());
        $movement->setDate($date);
        $movement->setWallet($wallet);

        return $this->movementRepository->save($movement);
    }
}
