<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Category;
use EventoOriginal\Core\Entities\CategoryTranslation;
use EventoOriginal\Core\Persistence\Repositories\CategoryRepository;
use Exception;

class CategoryService
{
    const DEFAULT_LOCALE = 'es';

    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function findOneById(int $id, string $locale)
    {
        $category = $this->categoryRepository->findOneById($id, $locale);

        if (!$category) {
            throw new Exception("This category doesn't exist");
        }

        return $category;
    }

    public function findAll(string $locale)
    {
        return $this->categoryRepository->findAll($locale);
    }

    public function create(string $name)
    {
        $category = new Category();
        $category->setName($name);

        $this->save($category, true);

        return $category;
    }

    public function addTranslation(Category $category, string $translatedName, string $locale)
    {
        $category->addTranslation(new CategoryTranslation($locale, 'name', $translatedName));
        $this->save($category);
    }

    public function update(Category $category, string $name)
    {
        $category->setName($name);

        $this->save($category);

        return $category;
    }

    public function delete(Category $category)
    {
        $this->categoryRepository->delete($category);
    }

    public function save(Category $category)
    {
        $this->categoryRepository->save($category);
    }

    public function getChildren(Category $category)
    {
        $children = $this->categoryRepository->findSubcategories($category);

        return $children;
    }

    public function createChildren(Category $parent, string $childName)
    {
        $category = new Category();
        $category->setName($childName);
        $category->setParent($parent);

        $this->save($category, true);
    }

    public function isChildren(Category $parent, Category $children)
    {
        $parents = $this->categoryRepository->getPath($parent);

        if (in_array($children , $parents)) {
            return true;
        } else {
            return false;
        }
    }
}
