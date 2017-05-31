<?php
namespace EventoOriginal\Core\Tests\Integration\Services;

use EventoOriginal\Core\Services\BrandService;
use EventoOriginal\Core\Tests\Integration\BaseTest;
use Exception;

class BrandServiceTest extends BaseTest
{
    /**
     * @var BrandService
     */
    private $brandService;

    public function setUp()
    {
        parent::setUp();

        $this->brandService = $this->getService('Brand');
    }

    public function testCreate()
    {
        $name = 'Coca cola';

        $brand = $this->brandService->create($name);

        $this->assertNotNull($brand->getId());
        $this->assertEquals($name, $brand->getName());
    }

    public function testFindOneById()
    {
        $name = 'Coca cola';

        $brand = $this->brandService->create($name);

        $brandSearched = $this->brandService->findOneById($brand->getId(), 'es');

        $this->assertEquals($brand->getId(), $brandSearched->getId());
    }

    public function testUpdate()
    {
        $originalName = 'Coca';

        $brand = $this->brandService->create($originalName);

        $newName = 'Coca cola';

        $this->brandService->update($brand, $newName);

        $brandSearched = $this->brandService->findOneById($brand->getId(), 'es');

        $this->assertEquals($newName, $brandSearched->getName());
    }

    public function testDelete()
    {
        $this->expectException(Exception::class);

        $brand = $this->brandService->create('Coca cola');

        $brandId = $brand->getId();

        $this->brandService->delete($brand);

        $this->brandService->findOneById($brandId, 'es');
    }
}
