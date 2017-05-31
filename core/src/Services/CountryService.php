<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Persistence\Repositories\CountryRepository;

class CountryService
{
    private $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }
}
