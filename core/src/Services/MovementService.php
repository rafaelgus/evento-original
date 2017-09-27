<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Movement;
use EventoOriginal\Core\Entities\Wallet;
use DateTime;
use EventoOriginal\Core\Persistence\Repositories\MovementRepository;

class MovementService
{
    private $movementRepository;

    public function __construct(MovementRepository $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    public function create(Wallet $wallet, string $type, $amount, DateTime $date)
    {
        $movement = new Movement();
        $movement->setType($type);
        $movement->setAmount($amount);
        $movement->setDate($date);
        $movement->setWallet($wallet);

        return $this->movementRepository->save($movement);
    }
}
