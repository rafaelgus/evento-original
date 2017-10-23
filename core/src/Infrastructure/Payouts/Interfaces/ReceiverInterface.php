<?php
namespace EventoOriginal\Core\Infrastructure\Payouts\Interfaces;

interface ReceiverInterface
{
    public function getId();
    public function getName();
    public function getPhone();
    public function getEmail();
}
