<?php
namespace EventoOriginal\Core\Infrastructure\Payments\Interfaces;

interface PayerInterface
{
    public function getId();
    public function getName();
    public function getPhone();
    public function getEmail();
    public function getIdentification();
}