<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Article;
use EventoOriginal\Core\Entities\Price;
use EventoOriginal\Core\Persistence\Repositories\PriceRepository;

class PriceService
{
    private $priceRepository;

    public function __construct(PriceRepository $priceRepository)
    {
        $this->priceRepository = $priceRepository;
    }

    /**
     * @param $currency
     * @param $amount
     * @param int $gramme
     * @param Article $article
     * @return Price
     */
    public function create(
        $currency,
        $amount,
        int $gramme,
        Article $article
    ) :Price {
        $price = new Price();
        $price->setArticle($article);
        $price->setGramme($gramme);
        $price->setPrice($amount);
        $price->setPriceCurrency($currency);

        $this->priceRepository->save($price, true);

        return $price;
    }
}