<?php
namespace EventoOriginal\Core\Tests\Services;

use EventoOriginal\Core\Tests\BaseTest;
use Exception;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;

class ColorServiceTest extends BaseTest
{
    private $colorService;

    public function setUp()
    {
        parent::setUp();

        $this->colorService = $this->getService('Color');
    }

    public function testFindByNonExistentId()
    {
        $this->expectException(Exception::class);
        $this->colorService->findOneById(999999999999);
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

        $translatedColorEn = $this->colorService->findOneInLocale($color->getId(), 'en');

        $this->assertEquals($translatedName, $translatedColorEn->getName());
    }
}
