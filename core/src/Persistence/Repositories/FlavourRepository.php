<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use Doctrine\ORM\Query;
use EventoOriginal\Core\Entities\Category;
use EventoOriginal\Core\Entities\Flavour;
use Gedmo\Translatable\Query\TreeWalker\TranslationWalker;
use Gedmo\Translatable\TranslatableListener;

class FlavourRepository extends BaseRepository
{
    const DEFAULT_LOCALE = 'es';

    public function findOneById(int $id, string $locale = self::DEFAULT_LOCALE)
    {
        $qb = $this->createQueryBuilder('flavour')
            ->select('flavour')
            ->where('flavour.id = :id')
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

    public function findOneByName(string $name, string $locale = self::DEFAULT_LOCALE)
    {
        $qb = $this->createQueryBuilder('flavour')
            ->select('flavour')
            ->where('flavour.name = :name')
            ->setMaxResults(1)
            ->setParameter('name', $name);

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
        $qb = $this->createQueryBuilder('flavour')->select('flavour');

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

    public function save(Flavour $flavour, bool $flush = true)
    {
        $this->getEntityManager()->persist($flavour);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(Flavour $flavour, bool $flush = true)
    {
        $this->getEntityManager()->remove($flavour);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getByCategorySlug(string $categorySlug, string $locale = 'es')
    {
        $qb = $this->createQueryBuilder('flavour')
            ->join(
                Category::class,
                'category',
                'WITH',
                'category.slug = :categorySlug'
            )
            ->join('category.children', 'children')
            ->join(
                'flavour.articles',
                'article',
                'WITH',
                'article.category = category.id OR article.category = children.id'
            )
            ->setParameters(['categorySlug' => $categorySlug]);

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
