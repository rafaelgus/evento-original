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
     * @return Price
     */
    public function create(
        $currency,
        $amount,
        int $gramme
    ): Price
    {
        $price = new Price();
        $price->setGramme($gramme);
        $price->setPrice($amount);
        $price->setPriceCurrency($currency);

        return $price;
    }

    /**
     * @param Price $price
     */
    public function save(Price $price)
    {
        $this->priceRepository->save($price, true);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->priceRepository->findAll();
    }

    /**
     * @param Article $article
     * @return array
     */
    public function findByArticle(Article $article)
    {
        return $this->priceRepository->findByArticle($article);
    }

    /**
     * @param int $id
     * @return null|Price
     */
    public function findById(int $id)
    {
        return $this->priceRepository->find($id);
    }
}