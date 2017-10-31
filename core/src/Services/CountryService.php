<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Country;
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

    /**
     * @param int $id
     * @return null|Country
     */
    public function findById(int $id)
    {
        return $this->countryRepository->find($id);
    }
}
