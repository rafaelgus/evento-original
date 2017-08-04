<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use Doctrine\ORM\Query;
use EventoOriginal\Core\Entities\Article;
use EventoOriginal\Core\Entities\Brand;
use EventoOriginal\Core\Entities\Category;
use EventoOriginal\Core\Entities\Color;
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

    public function getFilteredArticles(
        Category $category,
        array $brands,
        array $colors,
        array $flavours,
        array $licenses,
        array $tags,
        float $priceMin,
        float $priceMax,
        string $locale = 'es'
    ) {
        $em = $this->getEntityManager();

        if (count($brands) > 0) {
            $filter = $em->getFilters()->enable('article_brand');
            $filter->setParameter('brands', json_encode($brands));
        }

        if (count($licenses) > 0) {
            $filter = $em->getFilters()->enable('article_license');
            $filter->setParameter('licenses', json_encode($licenses));
        }

        $qb = $this->createQueryBuilder('article')
            ->select('article')
            ->join(
                Category::class,
                'category',
                'WITH',
                'category.id = :categoryId'
            )
            ->join('category.children', 'children')
            ->leftJoin('article.colors', 'color')
            ->leftJoin('article.flavours', 'flavour')
            ->leftJoin('article.tags', 'tag')
            ->setParameters(['categoryId' => $category->getId()])
            ->where('article.category = category.id OR article.category = children.id');

        if (count($colors) > 0) {
            $qb->where('color.id IN (' . implode(',', $colors) . ')');
        }

        if (count($flavours) > 0) {
            $qb->where('flavour.id IN (' . implode(',', $flavours) . ')');
        }

        if (count($tags) > 0) {
            $qb->where('tag.id IN (' . implode(',', $tags) . ')');
        }

        if ($priceMin) {
            $qb->where('article.price >= ' . $priceMin . ($priceMax ? ' AND article.price <= ' . $priceMax : ''));
        }

        $query = $qb->getQuery();
        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            TranslationWalker::class
        );
        $query->setHint(
            TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            $locale
        );

        $result = $query->getResult();

        return $result;
    }
}
