<?php

namespace App\Console\Commands;

use
    EventoOriginal\Core\Services\UserService;
use EventoOriginal\Core\Services\WalletService;
use Illuminate\Console\Command;

class LiquidateAffiliateCommissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eventoriginal:liquidate-commission {user?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Liquidate affiliate commissions';

    private $walletService;
    private $userService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(WalletService $walletService, UserService $userService)
    {
        parent::__construct();

        $this->walletService = $walletService;
        $this->userService = $userService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->argument('user')) {
            $userId = $this->argument('user');

            $this->info("Liquidate affiliate commission for user " . $userId);

            $user = $this->userService->findById($userId);

            if ($user) {
                $this->walletService->liquidateUserBalance($user);
            } else {
                $this->error("User not found");
            }

            $this->info("Done");
        } else {
            $this->info("Liquidate all commissions");

            $this->walletService->liquidateAllUsersBalance();

            $this->info("Done");
        }
    }
}
