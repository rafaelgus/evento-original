<?php

namespace EventoOriginal\Core\Persistence\Repositories;

use Doctrine\ORM\Query;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
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


    public function findAllPaginated(int $currentPage, int $maxItems)
    {
        $sql = 'SELECT * FROM articles';

        $query = $this->getEntityManager()
            ->createQuery($sql)
            ->setFirstResult($maxItems * ($currentPage - 1))
            ->setMaxResults($maxItems);

        $pagination = new Paginator($query, true);

        return $pagination;
    }

    public function findBySlug(string $slug)
    {
        return $this->findOneBy(['slug' => $slug]);
    }

    /**
     * @param array $categories
     * @param array $brands
     * @param array $colors
     * @param array $flavours
     * @param array $licenses
     * @param array $tags
     * @param array $healtyhs
     * @param float $priceMin
     * @param float|null $priceMax
     * @param string $locale
     * @param bool $paginate
     * @param int $pageLimit
     * @param int $page
     * @param string $orderBy
     * @return Paginator
     */
    public function getFilteredArticles(
        array $categories,
        array $brands,
        array $colors,
        array $flavours,
        array $licenses,
        array $tags,
        array $healtyhs,
        float $priceMin,
        float $priceMax = null,
        string $locale = 'es',
        bool $paginate = false,
        ?int $pageLimit = 9,
        ?int $page = 1,
        string $orderBy = 'position'
    ) {
        $categoriesIds = array_map(function ($category) {
            return $category->getId();
        }, $categories);


        $qb = $this->createQueryBuilder('article')
            ->select('article')
            ->leftJoin('article.colors', 'color')
            ->leftJoin('article.flavours', 'flavour')
            ->leftJoin('article.tags', 'tag')
            ->leftJoin('article.healthys', 'healthy')
            ->where('article.category IN (' . implode(',', $categoriesIds) . ')');

        if (count($brands) > 0) {
            $qb->andWhere('article.brand IN (' . implode(',', $brands) . ')');
        }

        if (count($licenses) > 0) {
            $qb->andWhere('article.license IN (' . implode(',', $licenses) . ')');
        }

        if (count($colors) > 0) {
            $qb->andWhere('color.id IN (' . implode(',', $colors) . ')');
        }

        if (count($flavours) > 0) {
            $qb->andWhere('flavour.id IN (' . implode(',', $flavours) . ')');
        }

        if (count($healtyhs) > 0) {
            $qb->andWhere('healthy.id IN (' . implode(',', $healtyhs) . ')');
        }

        if (count($tags) > 0) {
            $qb->andWhere('tag.id IN (' . implode(',', $tags) . ')');
        }

        if ($priceMin) {
            $qb->andWhere('article.price >= ' . $priceMin . ($priceMax ? ' AND article.price <= ' . $priceMax : ''));
        }

        $this->applyOrderBy($qb, $orderBy);

        $query = $qb->getQuery();
        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            TranslationWalker::class
        );
        $query->setHint(
            TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            $locale
        );

        $firstResult = (($pageLimit * ($page - 1)) > 0 ? ($pageLimit * ($page - 1)) : 0);

        $paginator = new Paginator($query, true);
        $paginator
            ->getQuery()
            ->setFirstResult($firstResult)
            ->setMaxResults($pageLimit);

        return $paginator;
    }

    public function applyOrderBy(QueryBuilder $qb, string $orderBy)
    {
        switch ($orderBy) {
            case 'position':
                break;
            case 'price_low':
                $qb->orderBy('article.price', 'ASC');
                break;
            case 'price_up':
                $qb->orderBy('article.price', 'DESC');
                break;
            case 'name':
                $qb->orderBy('article.name', 'ASC');
                break;
            default:
                break;
        }
    }

    public function findByCategory(Category $category, string $locale = 'es')
    {
        $qb = $this->createQueryBuilder('article')
            ->select('article')
            ->join(
                Category::class,
                'category',
                'WITH',
                'category.id = :categoryId'
            )
            ->leftJoin('category.children', 'children1')
            ->leftJoin('children1.children', 'children2')
            ->leftJoin('children2.children', 'children3')
            ->setParameters(['categoryId' => $category->getId()])
            ->where('article.category = category.id OR article.category = children1.id OR 
            article.category = children2.id OR article.category = children3.id');

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

    private function paginate($dql, $pageSize = 1, $currentPage = 1)
    {
        $paginator = new Paginator($dql, true);

        $paginator
            ->getQuery()
            ->setFirstResult($pageSize * ($currentPage - 1))
            ->setMaxResults($pageSize);

        return $paginator;
    }

    public function search(string $search)
    {
        $sql = 'SELECT articles.id FROM articles
                LEFT JOIN articles_colors on articles.id = articles_colors.article_id
                LEFT JOIN articles_tags on articles.id = articles_tags.article_id
                LEFT JOIN colors on colors.id = articles_colors.color_id
                LEFT JOIN tags on tags.id = articles_tags.tag_id
                LEFT JOIN article_ingredients on articles.id = article_ingredients.article_id
                LEFT JOIN ingredients on ingredients.id = article_ingredients.ingredient_id

                WHERE
                
                articles.name LIKE ' .  '"%' . $search . '%"' .' or 
                articles.description LIKE  ' . '"% . $search . %"' .' or 
                colors.name  LIKE  ' . '"% . $search . %"' .' or 
                tags.name LIKE  ' . '"% . $search . %"' .' or 
                ingredients.name LIKE  ' . '"%' . $search . '%"' ;

        $connection = $this->getEntityManager()->getConnection();

        $query = $connection->prepare($sql);
        $query->execute();

        $articlesIds = $query->fetchAll();

        $articles = [];

        foreach ($articlesIds as $articleId) {
            $article = $this->find($articleId);

            if ($article) {
                $articles[] = $article;
            }
        }

        return $articles;

    }

    public function paginateSearch(string $search, int $pageLimit = 10, int $page = 1)
    {
        $qb = $this->createQueryBuilder('article')
            ->select('article')
            ->leftJoin('article.colors', 'color')
            ->leftJoin('article.ingredients', 'ingredient')
            ->leftJoin('article.tags', 'tag')
            ->where('article.name LIKE :search 
                or article.description LIKE :search 
                or color.name LIKE :search 
                or ingredient.name LIKE :search 
                or tag.name LIKE :search'
            )
            ->setParameter('search', '%'.$search.'%');


        $firstResult = (($pageLimit * ($page - 1)) > 0 ? ($pageLimit * ($page - 1)) : 0);

        $paginator = new Paginator($qb->getQuery(), true);
        $paginator
            ->getQuery()
            ->setFirstResult($firstResult)
            ->setMaxResults($pageLimit);

        return $paginator;
    }

    public function findOneByBarCode(string $barCode)
    {
        return $this->findOneBy(['barCode' => $barCode]);
    }
}
