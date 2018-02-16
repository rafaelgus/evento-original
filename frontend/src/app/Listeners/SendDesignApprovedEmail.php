<?php
namespace App\Listeners;

use App\Events\DesignApproved;
use EventoOriginal\Core\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendDesignApprovedEmail implements ShouldQueue
{
    /**
     * @var MailService
     */
    private $mailService;

    /**
     * SendDesignRejectedEmail constructor.
     * @param MailService $mailService
     */
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * @param DesignApproved $event
     * @throws \Exception
     */
    public function handle(DesignApproved $event)
    {
        $this->mailService->sendDesignApproved($event->getDesign());
    }
}
