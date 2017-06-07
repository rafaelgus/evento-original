<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Brand;
use EventoOriginal\Core\Persistence\Repositories\BrandRepository;
use Exception;

class BrandService
{
    private $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function findOneById(int $id)
    {
        $brand = $this->brandRepository->findOneById($id);

        if (!$brand) {
            throw new Exception("This brand doesn't exist");
        }

        return $brand;
    }

    public function findAll()
    {
        return $this->brandRepository->findAll();
    }

    public function create(string $name)
    {
        $brand = new Brand();
        $brand->setName($name);

        $this->save($brand);

        return $brand;
    }

    public function update(Brand $brand, string $name)
    {
        $brand->setName($name);

        $this->save($brand);

        return $brand;
    }

    public function delete(Brand $brand)
    {
        $this->brandRepository->delete($brand);
    }

    public function save(Brand $brand)
    {
        $this->brandRepository->save($brand);
    }
}