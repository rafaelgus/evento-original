<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use Doctrine\ORM\Query;
use EventoOriginal\Core\Entities\Healthy;
use Gedmo\Translatable\Query\TreeWalker\TranslationWalker;
use Gedmo\Translatable\TranslatableListener;

class HealthyRepository extends BaseRepository
{
    const DEFAULT_LOCALE = 'es';

    public function findOneById(int $id, string $locale = self::DEFAULT_LOCALE)
    {
        $qb = $this->createQueryBuilder('healthy')
            ->select('healthy')
            ->where('healthy.id = :id')
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
        $qb = $this->createQueryBuilder('healthy')->select('healthy');

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

    public function save(Healthy $healthy, bool $flush = true)
    {
        $this->getEntityManager()->persist($healthy);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(Healthy $healthy, bool $flush = true)
    {
        $this->getEntityManager()->remove($healthy);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getByCategories(array $categories, string $locale = 'es')
    {
        $categoriesIds = array_map(function ($category) {
            return $category->getId();
        }, $categories);

        $qb = $this->createQueryBuilder('healthy')
            ->join(
                'healthy.articles',
                'article',
                'WITH',
                'article.category IN (' . implode(',', $categoriesIds) . ')'
            );

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
}
