<?php
namespace EventoOriginal\Core\Tests\Integration\Services;

use EventoOriginal\Core\Services\ColorService;
use EventoOriginal\Core\Tests\Integration\BaseTest;
use Exception;

class ColorServiceTest extends BaseTest
{
    /**
     * @var ColorService
     */
    private $colorService;

    public function setUp()
    {
        parent::setUp();

        $this->colorService = $this->getService('Color');
    }

    public function testFindByNonExistentId()
    {
        $this->expectException(Exception::class);
        $this->colorService->findOneById(999999999999, 'es');
    }

    public function testCreate()
    {
        $name = 'Azul';

        $color = $this->colorService->create($name);

        $this->assertNotNull($color->getId());
        $this->assertEquals($name, $color->getName());
    }

    public function testAddTranslation()
    {
        $name = 'Rojo';
        $translatedName = 'Red';

        $color = $this->colorService->create($name);
        $this->assertEquals($name, $color->getName());

        $this->colorService->addTranslation($color, $translatedName, 'en');

        $translatedColorEn = $this->colorService->findOneById($color->getId(), 'en');

        $this->assertEquals($translatedName, $translatedColorEn->getName());
    }

    public function testFindOneById()
    {
        $name = 'Rojo';

        $color = $this->colorService->create($name);

        $colorSearched = $this->colorService->findOneById($color->getId(), 'es');

        $this->assertEquals($color->getId(), $colorSearched->getId());
    }

    public function testFindOneByName()
    {
        $name = 'Rojo';

        $this->colorService->create($name);

        $color = $this->colorService->findOneByName($name, 'es');

        $this->assertEquals($name, $color->getName());
    }

    public function testUpdate()
    {
        $originalName = 'Roj';

        $color = $this->colorService->create($originalName);

        $newName = 'Rojo';

        $this->colorService->update($color, $newName);

        $colorSearched = $this->colorService->findOneById($color->getId(), 'es');

        $this->assertEquals($newName, $colorSearched->getName());
    }

    public function testDelete()
    {
        $this->expectException(Exception::class);

        $color = $this->colorService->create('rojo');

        $colorId = $color->getId();

        $this->colorService->delete($color);

        $this->colorService->findOneById($colorId, 'es');
    }
}
