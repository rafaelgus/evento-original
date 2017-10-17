<?php

namespace EventoOriginal\Core\Services;

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
        $data = [
            "id" => $templateId,
            "to" => $data['to'],
            "cc" => $data['cc'],
            "bcc" => $data['bcc'],
            "replyto" => $data['reply_to'],
            "attr" => $data['attr'],
            "attachment_url" => $data['attachment_url'],
            "attachment" => $data['attachment'],
            "headers" => [
                "Content-Type" => "text/html;charset=iso-8859-1",
                "X-param1" => "value1",
                "X-param2" => "value2",
                "X-Mailin-custom" => "my custom value",
                "X-Mailin-tag" => "my tag value"
            ]
        ];

        logger()->info($this->client->send_transactional_template($data));
    }
}
