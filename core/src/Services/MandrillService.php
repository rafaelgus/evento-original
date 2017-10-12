<?php

namespace EventoOriginal\Core\Services;

use InvalidArgumentException;
use Mandrill;
use Mandrill_Error;

class MandrillService
{
    private $mandrill;

    public function __construct(Mandrill $mandrill)
    {
        $this->mandrill = $mandrill;
    }

    public function sendTemplate(array $data, string $templateName)
    {
        if (!array_has($data, 'messageParams.to')) {
            throw new InvalidArgumentException("Sorry but params to(email and name) are required", 1);
        }

        if (empty($templateName)) {
            throw new InvalidArgumentException("Template name is required", 1);
        }

        $templateContent = array_get($data, 'params');
        $message = array_get($data, 'messageParams');

        try {
            $result = $this->mandrill->messages->sendTemplate($templateName, $templateContent, $message);
        } catch (Mandrill_Error $e) {
            logger()->error('Error sending ' . $templateName . ' email to ' .
                $data['email'] . ' : ' . $e->getMessage());
        }

        return empty($result) ? false : $result;
    }
}
