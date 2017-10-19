<?php
namespace EventoOriginal\Core\Tests\Integration\Services;

use EventoOriginal\Core\Services\CategoryService;
use EventoOriginal\Core\Tests\Integration\BaseTest;
use Exception;

class CategoryServiceTest extends BaseTest
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    public function setUp()
    {
        parent::setUp();

        $this->categoryService = $this->getService('Category');
    }

    public function testFindByNonExistentId()
    {
        $this->expectException(Exception::class);
        $this->categoryService->findOneById(999999999999, 'es');
    }

    public function testCreate()
    {
        $name = 'Tazas';

        $category = $this->categoryService->create($name);

        $this->assertNotNull($category->getId());
        $this->assertEquals($name, $category->getName());
    }

    public function testAddTranslation()
    {
        $name = 'Tazas';
        $translatedName = 'Mugs';

        $category = $this->categoryService->create($name);
        $this->assertEquals($name, $category->getName());

        $this->categoryService->addTranslation($category, $translatedName, 'en');

        $translatedCategory = $this->categoryService->findOneById($category->getId(), 'en');

        $this->assertEquals($translatedName, $translatedCategory->getName());
    }

    public function testFindOneById()
    {
        $name = 'Taza';

        $category = $this->categoryService->create($name);

        $categorySearched = $this->categoryService->findOneById($category->getId(), 'es');

        $this->assertEquals($category->getId(), $categorySearched->getId());
    }

    public function testUpdate()
    {
        $originalName = 'Tassa';

        $category = $this->categoryService->create($originalName);

        $newName = 'Taza';

        $this->categoryService->update($category, $newName);

        $categorySearched = $this->categoryService->findOneById($category->getId(), 'es');

        $this->assertEquals($newName, $categorySearched->getName());
    }

    public function testDelete()
    {
        $this->expectException(Exception::class);

        $category = $this->categoryService->create('Taza');

        $categoryId = $category->getId();

        $this->categoryService->delete($category);

        $this->categoryService->findOneById($categoryId, 'es');
    }
}