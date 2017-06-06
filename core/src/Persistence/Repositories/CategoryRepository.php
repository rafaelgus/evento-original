<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use Doctrine\ORM\Query;
use EventoOriginal\Core\Entities\Category;
use Gedmo\Translatable\Query\TreeWalker\TranslationWalker;
use Gedmo\Translatable\TranslatableListener;

class CategoryRepository extends BaseRepository
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
}
