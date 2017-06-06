<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use Doctrine\ORM\Query;
use EventoOriginal\Core\Entities\Tag;
use Gedmo\Translatable\Query\TreeWalker\TranslationWalker;
use Gedmo\Translatable\TranslatableListener;

class TagRepository extends BaseRepository
{
    const DEFAULT_LOCALE = 'es';

    public function findOneById(int $id, string $locale = self::DEFAULT_LOCALE)
    {
        $qb = $this->createQueryBuilder('tag')
            ->select('tag')
            ->where('tag.id = :id')
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
        $qb = $this->createQueryBuilder('tag')
            ->select('tag')
            ->where('tag.name = :name')
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
        $qb = $this->createQueryBuilder('tag')->select('tag');

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

    public function save(Tag $tag, bool $flush = true)
    {
        $this->getEntityManager()->persist($tag);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(Tag $tag, bool $flush = true)
    {
        $this->getEntityManager()->remove($tag);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
