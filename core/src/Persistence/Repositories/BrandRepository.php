<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use Doctrine\ORM\Query;
use EventoOriginal\Core\Entities\Article;
use EventoOriginal\Core\Entities\Brand;
use EventoOriginal\Core\Entities\Category;
use Gedmo\Translatable\Query\TreeWalker\TranslationWalker;
use Gedmo\Translatable\TranslatableListener;

class BrandRepository extends BaseRepository
{
    public function findOneById(int $id)
    {
        return $this->find($id);
    }

    public function save(Brand $brand, bool $flush = true)
    {
        $this->getEntityManager()->persist($brand);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(Brand $brand, bool $flush = true)
    {
        $this->getEntityManager()->remove($brand);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getByCategories(array $categories, string $locale = 'es')
    {
        $categoriesIds = array_map(function ($category) {
            return $category->getId();
        }, $categories);

        $qb = $this->createQueryBuilder('brand')
            ->select('brand')
            ->join(
                Article::class,
                'article',
                'WITH',
                'article.brand = brand.id AND (article.category IN (' . implode(',', $categoriesIds) . '))'
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
