<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\License;
use EventoOriginal\Core\Persistence\Repositories\LicenseRepository;

class LicenseService
{
    protected $licenseRepository;

    public function __construct(LicenseRepository $licenseRepository)
    {
        $this->licenseRepository = $licenseRepository;
    }

    /**
     * @param string $name
     * @return License
     */
    public function create(string $name)
    {
        $license = new License();
        $license->setName($name);

        $this->licenseRepository->save($license, true);

        return $license;
    }

    /**
     * @param License $license
     * @param string $name
     */
    public function update(License $license, string $name)
    {
        $license->setName($name);
        $this->licenseRepository->save($license, true);
    }

    /**
     * @param int $id
     * @return null|object
     */
    public function findOneById(int $id)
    {
        $license = $this->licenseRepository->findById($id);

        return $license;
    }
}