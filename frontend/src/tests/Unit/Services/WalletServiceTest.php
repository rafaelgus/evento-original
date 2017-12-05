<?php
namespace Tests\Unit\Services;

use EventoOriginal\Core\Entities\Movement;
use EventoOriginal\Core\Entities\Wallet;
use EventoOriginal\Core\Enums\MovementType;
use EventoOriginal\Core\Persistence\Repositories\WalletRepository;
use EventoOriginal\Core\Services\MovementService;
use EventoOriginal\Core\Services\WalletService;
use Mockery as m;
use Money\Currency;
use Money\Money;
use Tests\TestCase;

class WalletServiceTest extends TestCase
{
    /**
     * @var WalletService
     */
    private $walletService;

    public function setUp()
    {
        parent::setUp();

        $this->walletService = $this->app->make(WalletService::class);

        $walletRepositoryMock = m::mock(WalletRepository::class);
        $walletRepositoryMock->shouldReceive('save')->andReturnNull();

        $this->set($this->walletService, 'walletRepository', $walletRepositoryMock);
    }

    public function testAddBalance()
    {
        $wallet = new Wallet();

        $movementMock = m::mock(Movement::class);

        $movementServiceMock = m::mock(MovementService::class);
        $movementServiceMock->shouldReceive('create')->andReturn($movementMock);

        $this->set($this->walletService, 'movementService', $movementServiceMock);

        $money = new Money(50, new Currency('EUR'));

        $this->walletService->addBalance($wallet, $money, MovementType::AFFILIATE_COMMISSION_CREDIT);

        $this->assertEquals($wallet->getBalanceMoney()->getAmount(), $money->getAmount());
    }

    public function testAddBalanceWithCents()
    {
        $wallet = new Wallet();
        $initialBalance = 1023;
        $wallet->setBalance($initialBalance);

        $movementMock = m::mock(Movement::class);

        $movementServiceMock = m::mock(MovementService::class);
        $movementServiceMock->shouldReceive('create')->andReturn($movementMock);

        $this->set($this->walletService, 'movementService', $movementServiceMock);

        $money = new Money(5053, new Currency('EUR'));

        $this->walletService->addBalance($wallet, $money, MovementType::AFFILIATE_COMMISSION_CREDIT);

        $this->assertEquals($wallet->getBalanceMoney()->getAmount(), $money->getAmount() + $initialBalance);
    }
}
