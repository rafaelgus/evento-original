<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use EventoOriginal\Core\Entities\Article;
use Gedmo\Translatable\Query\TreeWalker\TranslationWalker;
use Gedmo\Translatable\TranslatableListener;

class ArticleRepository extends BaseRepository
{
    const DEFAULT_LOCALE = 'es';

    public function findOneById(int $id, string $locale = self::DEFAULT_LOCALE)
    {
        $qb = $this->createQueryBuilder('article')
            ->select('article')
            ->where('article.id = :id')
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
        $qb = $this->createQueryBuilder('article')->select('article');

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

    public function save(Article $article, bool $flush = true)
    {
        $this->getEntityManager()->persist($article);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(Article $article, bool $flush = true)
    {
        $this->getEntityManager()->remove($article);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllPaginated(int $currentPage, int $maxItems)
    {
        $sql = 'SELECT *FROM articles';

        $query = $this->getEntityManager()
            ->createQuery($sql)
            ->setFirstResult($maxItems * ($currentPage - 1))
            ->setMaxResults($maxItems);

        $pagination = new Paginator($query, true);

        return $pagination;
    }
}
