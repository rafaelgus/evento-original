<?php
namespace EventoOriginal\Core\Infrastructure\Payments\Exceptions;

use Exception;

class InvalidPaymentStatusException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}