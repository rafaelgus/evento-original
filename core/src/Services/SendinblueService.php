<?php

namespace EventoOriginal\Core\Services;

use Exception;
use InvalidArgumentException;
use Mailin;

class SendinblueService
{
    private $client;

    public const WELCOME_ADMIN_TEMPLATE_ID = 1;

    public function __construct(Mailin $client)
    {
        $this->client = $client;
    }

    public function sendTemplate(int $templateId, array $data)
    {
        $emailData = [];
        $emailData['id'] = $templateId;

        if (isset($data['to']) || array_key_exists('to', $data)) {
            $emailData['to'] =  $data['to'];
        } else {
            throw new InvalidArgumentException("Receiver is required");
        }

        if (isset($data['cc']) || array_key_exists('cc', $data)) {
            $emailData['cc'] =  $data['cc'];
        }

        if (isset($data['bcc']) || array_key_exists('bcc', $data)) {
            $emailData['bcc'] =  $data['bcc'];
        }

        if (isset($data['replyto']) || array_key_exists('replyto', $data)) {
            $emailData['replyto'] =  $data['replyto'];
        }

        if (isset($data['attachment']) || array_key_exists('attachment', $data)) {
            $emailData['attachment'] =  $data['attachment'];
        }

        $emailData["headers"] = [];
        $emailData["headers"]["Content-Type"] = "text/html;charset=iso-8859-1";

        //TODO Implementar envio de parametros

        try {
            $response = $this->client->send_transactional_template($emailData);

            logger()->info($response);

            return $response;

        } catch (Exception $exception) {
            logger()->error("Error sending welcome email: " . $exception->getMessage());

            throw $exception;
        }
    }
}
