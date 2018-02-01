<?php

namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Category;
use EventoOriginal\Core\Entities\CategoryTranslation;
use EventoOriginal\Core\Persistence\Repositories\CategoryRepository;
use Exception;

class CategoryService
{
    const DEFAULT_LOCALE = 'es';
    const DEFAULT_AFFILIATE_COMMISSION = 5;

    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function findOneById(int $id, string $locale = 'es')
    {
        $category = $this->categoryRepository->findOneById($id, $locale);

        return $category;
    }

    public function findAll(string $locale)
    {
        return $this->categoryRepository->findAll($locale);
    }

    public function create(
        string $name,
        string $slug,
        string $description,
        $affiliateCommission = self::DEFAULT_AFFILIATE_COMMISSION
    ) {
        $category = new Category();
        $category->setName($name);
        $category->setSlug($slug);
        $category->setDescription($description);
        $category->setAffiliateCommission($affiliateCommission);

        $this->save($category, true);

        return $category;
    }

    public function addTranslation(
        Category $category,
        string $translatedName,
        string $translatedSlug,
        string $translatedDescription,
        string $locale
    ) {
        $category->addTranslation(new CategoryTranslation($locale, 'name', $translatedName));
        $category->addTranslation(new CategoryTranslation($locale, 'slug', $translatedSlug));
        $category->addTranslation(new CategoryTranslation($locale, 'description', $translatedDescription));
        $this->save($category);
    }

    public function update(
        Category $category,
        string $name,
        string $slug,
        string $description,
        $affiliateCommission = null
    ) {
        $category->setName($name);
        $category->setSlug($slug);
        $category->setDescription($description);
        $this->save($category);

        if ($affiliateCommission) {
            $category->setAffiliateCommission($affiliateCommission);
        }

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

    public function getChildren(
        Category $category,
        $direct = false,
        $sortByField = null,
        $direction = 'ASC',
        $includeNode = false
    ) {
        $children = $this->categoryRepository->findSubcategories(
            $category,
            $direct,
            $sortByField,
            $direction,
            $includeNode
        );

        return $children;
    }

    public function createChildren(
        Category $parent,
        string $childName,
        string $childSlug,
        string $childDescription,
        $childAffiliateCommission = self::DEFAULT_AFFILIATE_COMMISSION
    ) {
        $category = new Category();
        $category->setName($childName);
        $category->setSlug($childSlug);
        $category->setDescription($childDescription);
        $category->setParent($parent);
        $category->setAffiliateCommission($childAffiliateCommission);

        $this->save($category, true);
    }


    public function isChildren(Category $parent, Category $children)
    {
        $parents = $this->categoryRepository->getPath($parent);

        if (in_array($children, $parents)) {
            return true;
        } else {
            return false;
        }
    }

    public function findBySlug(string $slug, string $locale = 'es')
    {
        return $this->categoryRepository->findBySlug($slug, $locale);
    }

    public function applyCommissionToChildren(Category $category, int $affiliateCommission)
    {
        foreach ($category->getChildren() as $child) {
            $child->setAffiliateCommission($affiliateCommission);

            $this->save($child);
        }
    }
}
