<?php
namespace App\Listeners;

use App\Events\DesignRejected;
use EventoOriginal\Core\Services\MailService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendDesignRejectedEmail implements ShouldQueue
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
     * @param DesignRejected $event
     * @throws \Exception
     */
    public function handle(DesignRejected $event)
    {
        $this->mailService->sendDesignRejected($event->getDesign());
    }
}
