<?php
namespace EventoOriginal\Core\Tests\Integration\Services;

use EventoOriginal\Core\Entities\Article;
use EventoOriginal\Core\Entities\Brand;
use EventoOriginal\Core\Services\ArticleService;
use EventoOriginal\Core\Services\BrandService;
use EventoOriginal\Core\Services\CategoryService;
use EventoOriginal\Core\Services\TagService;
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
     * @var CategoryService
     */
    private $categoryService;

    /**
     * @var TagService
     */
    private $tagService;

    public function setUp()
    {
        parent::setUp();

        $this->articleService = $this->getService('Article');
        $this->brandService = $this->getService('Brand');
        $this->categoryService = $this->getService('Category');
        $this->tagService = $this->getService('Tag');
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
        $category = $this->categoryService->findAll('es')[0];
        $tags = $this->tagService->findAll('es');

        $article = $this->articleService->create(
            $name,
            $description,
            $barCode,
            $internalCode,
            $status,
            $price,
            $priceCurrency,
            null,
            $costPrice,
            $ingredients,
            $brand,
            $category,
            $tags
        );

        $this->assertNotNull($article->getId());
        $this->assertEquals($name, $article->getName());
        $this->assertEquals($description, $article->getDescription());
        $this->assertEquals($barCode, $article->getBarCode());
        $this->assertEquals($internalCode, $article->getInternalCode());
        $this->assertEquals($status, $article->getStatus());
        $this->assertEquals($price, $article->getPrice());
        $this->assertEquals($priceCurrency, $article->getPriceCurrency());
        $this->assertEquals($costPrice, $article->getCostPrice());
        $this->assertEquals($ingredients, $article->getIngredients());
        $this->assertEquals($brand, $article->getBrand());
        $this->assertEquals($category, $article->getCategory());
        $this->assertEquals($tags, $article->getTags()->toArray());
        $this->assertNull($article->getPublishedOn());
    }

    public function testAddTranslation()
    {
        $name = 'Taza';
        $translatedName = 'Cup';
        $description = 'Taza de porcelana';
        $translatedDescription = 'Porcelain cup';
        $barCode = '123456';
        $internalCode = '11002';
        $status = Article::STATUS_DRAFT;
        $price = 1.54;
        $priceCurrency = 'EUR';
        $costPrice = 1.22;
        $ingredients = "Azucar";
        $translatedIngredients = "Sugar";

        $brand = $this->brandService->findAll()[0];
        $category = $this->categoryService->findAll('es')[0];
        $tags = $this->tagService->findAll('es');

        $article = $this->articleService->create(
            $name,
            $description,
            $barCode,
            $internalCode,
            $status,
            $price,
            $priceCurrency,
            null,
            $costPrice,
            $ingredients,
            $brand,
            $category,
            $tags
        );

        $this->articleService->addTranslation(
            $article,
            'en',
            $translatedName,
            $translatedDescription,
            $translatedIngredients
        );

        $articleTranslated = $this->articleService->findOneById($article->getId(), 'en');

        $this->assertEquals($translatedName, $articleTranslated->getName());
        $this->assertEquals($translatedDescription, $articleTranslated->getDescription());
        $this->assertEquals($translatedIngredients, $articleTranslated->getIngredients());
    }

    public function testFindOneById()
    {
        $name = 'Taza';
        $description = 'Taza de porcelana';
        $barCode = '123456';
        $internalCode = '11002';
        $status = Article::STATUS_DRAFT;
        $price = 1.54;
        $priceCurrency = 'EUR';
        $costPrice = 1.22;
        $ingredients = "Azucar";

        $brand = $this->brandService->findAll()[0];
        $category = $this->categoryService->findAll('es')[0];
        $tags = $this->tagService->findAll('es');

        $article = $this->articleService->create(
            $name,
            $description,
            $barCode,
            $internalCode,
            $status,
            $price,
            $priceCurrency,
            null,
            $costPrice,
            $ingredients,
            $brand,
            $category,
            $tags
        );

        $articleSearched = $this->articleService->findOneById($article->getId(), 'es');

        $this->assertEquals($article->getId(), $articleSearched->getId());
    }

    public function testAddArticleWithPublishedStatus()
    {
        $name = 'Taza';
        $description = 'Taza de porcelana';
        $barCode = '123456';
        $internalCode = '11002';
        $status = Article::STATUS_PUBLISHED;
        $price = 1.54;
        $priceCurrency = 'EUR';
        $costPrice = 1.22;
        $ingredients = "";

        $brand = $this->brandService->findAll()[0];
        $category = $this->categoryService->findAll('es')[0];
        $tags = $this->tagService->findAll('es');

        $article = $this->articleService->create(
            $name,
            $description,
            $barCode,
            $internalCode,
            $status,
            $price,
            $priceCurrency,
            null,
            $costPrice,
            $ingredients,
            $brand,
            $category,
            $tags
        );

        $this->assertEquals($status, $article->getStatus());
        $this->assertNotNull($article->getPublishedOn());
    }
}
