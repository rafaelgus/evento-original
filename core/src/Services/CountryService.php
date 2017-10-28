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

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->countryRepository->findAll();
    }
}
