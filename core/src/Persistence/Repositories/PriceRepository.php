<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Article;
use EventoOriginal\Core\Entities\Price;

class PriceRepository extends BaseRepository
{
    public function save(Price $price, bool $flush = null)
    {
        $this->getEntityManager()->persist($price);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByArticle(Article $article)
    {
        return $this->findBy(['article' => $article->getId()]);
    }
}
