<?php
namespace EventoOriginal\Core\Tests\Integration\Services;

use EventoOriginal\Core\Services\FlavourService;
use EventoOriginal\Core\Tests\Integration\BaseTest;
use Exception;

class FlavourServiceTest extends BaseTest
{
    /**
     * @var FlavourService
     */
    private $flavourService;

    public function setUp()
    {
        parent::setUp();

        $this->flavourService = $this->getService('Flavour');
    }

    public function testFindByNonExistentId()
    {
        $this->expectException(Exception::class);
        $this->flavourService->findOneById(999999999999, 'es');
    }

    public function testCreate()
    {
        $name = 'Fresa';

        $flavour = $this->flavourService->create($name);

        $this->assertNotNull($flavour->getId());
        $this->assertEquals($name, $flavour->getName());
    }

    public function testAddTranslation()
    {
        $name = 'Manzana';
        $translatedName = 'Apple';

        $flavour = $this->flavourService->create($name);
        $this->assertEquals($name, $flavour->getName());

        $this->flavourService->addTranslation($flavour, $translatedName, 'en');

        $translatedFlavour = $this->flavourService->findOneById($flavour->getId(), 'en');

        $this->assertEquals($translatedName, $translatedFlavour->getName());
    }

    public function testFindOneById()
    {
        $name = 'Fresa';

        $flavour = $this->flavourService->create($name);

        $flavourSearched = $this->flavourService->findOneById($flavour->getId(), 'es');

        $this->assertEquals($flavour->getId(), $flavourSearched->getId());
    }

    public function testFindOneByName()
    {
        $name = 'Fresa';

        $this->flavourService->create($name);

        $flavour = $this->flavourService->findOneByName($name, 'es');

        $this->assertEquals($name, $flavour->getName());
    }

    public function testUpdate()
    {
        $originalName = 'Fre';

        $flavour = $this->flavourService->create($originalName);

        $newName = 'Fresa';

        $this->flavourService->update($flavour, $newName);

        $flavourSearched = $this->flavourService->findOneById($flavour->getId(), 'es');

        $this->assertEquals($newName, $flavourSearched->getName());
    }

    public function testDelete()
    {
        $this->expectException(Exception::class);

        $flavour = $this->flavourService->create('Fresa');

        $flavourId = $flavour->getId();

        $this->flavourService->delete($flavour);

        $this->flavourService->findOneById($flavourId, 'es');
    }
}
