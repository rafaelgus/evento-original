<?php
namespace EventoOriginal\Core\Tests\Integration\Services;

use EventoOriginal\Core\Services\AllergenService;
use EventoOriginal\Core\Tests\Integration\BaseTest;
use Exception;

class AllergenServiceTest extends BaseTest
{
    /**
     * @var AllergenService
     */
    private $allergenService;

    public function setUp()
    {
        parent::setUp();

        $this->allergenService = $this->getService('Allergen');
    }

    public function testFindByNonExistentId()
    {
        $this->expectException(Exception::class);
        $this->allergenService->findOneById(999999999999, 'es');
    }

    public function testCreate()
    {
        $name = 'Gluten';

        $allergen = $this->allergenService->create($name);

        $this->assertNotNull($allergen->getId());
        $this->assertEquals($name, $allergen->getName());
    }

    public function testAddTranslation()
    {
        $name = 'Pescado';
        $translatedName = 'Fish';

        $allergen = $this->allergenService->create($name);
        $this->assertEquals($name, $allergen->getName());

        $this->allergenService->addTranslation($allergen, $translatedName, 'en');

        $translatedAllergen = $this->allergenService->findOneById($allergen->getId(), 'en');

        $this->assertEquals($translatedName, $translatedAllergen->getName());
    }

    public function testUpdate()
    {
        $originalName = 'Alerg';

        $allergen = $this->allergenService->create($originalName);

        $newName = 'Alergeno';

        $this->allergenService->update($allergen, $newName);

        $allergenUpdated = $this->allergenService->findOneById($allergen->getId(), 'es');

        $this->assertEquals($newName, $allergenUpdated->getName());
    }

    public function testDelete()
    {
        $this->expectException(Exception::class);

        $allergen = $this->allergenService->create('Alergeno');

        $allergenId = $allergen->getId();

        $this->allergenService->delete($allergen);

        $this->allergenService->findOneById($allergenId, 'es');
    }
}
