<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\User;

class MailService
{
    private $sendinblueService;

    public function __construct(SendinblueService $sendinblueService)
    {
        $this->sendinblueService = $sendinblueService;
    }

    public function sendWelcome(User $user)
    {
        $this->sendinblueService->sendWelcome($user);
    }
}
