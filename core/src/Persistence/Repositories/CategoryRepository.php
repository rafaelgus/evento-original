<?php

namespace EventoOriginal\Core\Persistence\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\Query;
use EventoOriginal\Core\Entities\Category;
use Gedmo\Translatable\Query\TreeWalker\TranslationWalker;
use Gedmo\Translatable\TranslatableListener;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

class CategoryRepository extends NestedTreeRepository
{
    const DEFAULT_LOCALE = 'es';

    public function findOneById(int $id, string $locale = self::DEFAULT_LOCALE)
    {
        $qb = $this->createQueryBuilder('category')
            ->select('category')
            ->where('category.id = :id')
            ->setMaxResults(1)
            ->setParameter('id', $id);

        $query = $qb->getQuery();

        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            TranslationWalker::class
        );
        $query->setHint(
            TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            $locale
        );

        return $query->getOneOrNullResult();
    }

    public function findAll(string $locale = self::DEFAULT_LOCALE)
    {
        $qb = $this->createQueryBuilder('category')->select('category');

        $query = $qb->getQuery();

        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            TranslationWalker::class
        );
        $query->setHint(
            TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            $locale
        );

        return $query->getResult();
    }

    public function save(Category $category, bool $flush = true)
    {
        $this->getEntityManager()->persist($category);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(Category $category, bool $flush = true)
    {
        $this->getEntityManager()->remove($category);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findSubcategories(
        Category $category,
        $direct = false,
        $sortByField = null,
        $direction = 'ASC',
        $includeNode = false
    ) {
        $subcategories = $this
            ->children($category, $direct, $sortByField, $direction, $includeNode);

        return $subcategories;
    }


    public function getParents(Category $category)
    {
        return $this->getPath($category);
    }

    public function findBySlug(string $slug, string $locale)
    {
        $qb = $this->createQueryBuilder('category')
            ->select('category')
            ->where('category.slug = :slug')
            ->setMaxResults(1)
            ->setParameter('slug', $slug);

        $query = $qb->getQuery();

        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            TranslationWalker::class
        );
        $query->setHint(
            TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            $locale
        );

        return $query->getOneOrNullResult();
    }
}
