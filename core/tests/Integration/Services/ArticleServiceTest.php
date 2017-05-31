<?php
namespace EventoOriginal\Core\Tests\Integration\Services;

use EventoOriginal\Core\Entities\Article;
use EventoOriginal\Core\Entities\Brand;
use EventoOriginal\Core\Services\ArticleService;
use EventoOriginal\Core\Services\BrandService;
use EventoOriginal\Core\Tests\Integration\BaseTest;
use Exception;

class ArticleServiceTest extends BaseTest
{
    /**
     * @var ArticleService
     */
    private $articleService;

    /**
     * @var BrandService
     */
    private $brandService;

    /**
     * @var Caeg
     */
    private $categoryServvice;

    public function setUp()
    {
        parent::setUp();

        $this->articleService = $this->getService('Article');
        $this->brandService = $this->getService('Brand');
    }

    public function testFindByNonExistentId()
    {
        $this->expectException(Exception::class);
        $this->articleService->findOneById(999999999999, 'es');
    }

    public function testCreate()
    {
        $name = 'Taza';
        $description = 'Taza de porcelana';
        $barCode = '123456';
        $internalCode = '11002';
        $status = Article::STATUS_DRAFT;
        $price = 1.54;
        $priceCurrency = 'EUR';
        $costPrice = 1.22;
        $ingredients = "";

        $brand = $this->brandService->findAll()[0];
        $category = $this->categoryService->findAll()[0];

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
