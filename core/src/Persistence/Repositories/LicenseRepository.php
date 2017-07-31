<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use Doctrine\ORM\Query;
use EventoOriginal\Core\Entities\Article;
use EventoOriginal\Core\Entities\Category;
use EventoOriginal\Core\Entities\License;
use Gedmo\Translatable\Query\TreeWalker\TranslationWalker;
use Gedmo\Translatable\TranslatableListener;

class LicenseRepository extends BaseRepository
{
    public function save(License $license, bool $flush = true)
    {
        $this->getEntityManager()->persist($license);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(License $license, bool $flush = true)
    {
        $this->getEntityManager()->remove($license);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(int $id)
    {
        return $this->find($id);
    }

    public function getByCategorySlug(string $categorySlug, string $locale = 'es')
    {
        $qb = $this->createQueryBuilder('license')
            ->select('license')
            ->join(
                Category::class,
                'category',
                'WITH',
                'category.slug = :categorySlug'
            )
            ->join('category.children', 'children')
            ->join(
                Article::class,
                'article',
                'WITH',
                'article.license = license.id AND (article.category = category.id OR article.category = children.id)'
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