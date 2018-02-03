<?php
namespace App\Listeners;

use App\Events\UserRegistered;
use EventoOriginal\Core\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWelcomeEmail implements ShouldQueue
{
    private $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function handle(UserRegistered $userRegistered)
    {
        $this->mailService->sendWelcome($userRegistered->user);
    }
}
