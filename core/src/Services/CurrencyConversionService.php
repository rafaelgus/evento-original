<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Persistence\Repositories\CurrencyConversionRepository;

class CurrencyConversionService
{
    private $currencyConversionRepository;

    public function __construct(CurrencyConversionRepository $currencyConversionRepository)
    {
        $this->currencyConversionRepository = $currencyConversionRepository;
    }
}
