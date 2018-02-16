<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Design;
use EventoOriginal\Core\Entities\User;

class MailService
{
    private $sendinblueService;

    public function __construct(SendinblueService $sendinblueService)
    {
        $this->sendinblueService = $sendinblueService;
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    public function sendWelcome(User $user)
    {
        $this->sendinblueService->sendWelcome($user);
    }

    /**
     * @param Design $design
     * @throws \Exception
     */
    public function sendDesignApproved(Design $design)
    {
        $this->sendinblueService->sendDesignApproved($design);
    }

    /**
     * @param Design $design
     * @throws \Exception
     */
    public function sendDesignRejected(Design $design)
    {
        $this->sendinblueService->sendDesignRejected($design);
    }
}
