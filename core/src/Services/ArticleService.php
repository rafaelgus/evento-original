<?php
namespace EventoOriginal\Core\Services;

use DateTime;
use EventoOriginal\Core\Entities\Article;
use EventoOriginal\Core\Entities\ArticleTranslation;
use EventoOriginal\Core\Entities\Brand;
use EventoOriginal\Core\Entities\Category;
use EventoOriginal\Core\Entities\License;
use EventoOriginal\Core\Entities\Tax;
use EventoOriginal\Core\Persistence\Repositories\ArticleRepository;
use Exception;

class ArticleService
{
    const DEFAULT_LOCALE = 'es';

    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @param int $id
     * @param string $locale
     * @return mixed
     * @throws Exception
     */
    public function findOneById(int $id, string $locale)
    {
        $article = $this->articleRepository->findOneById($id, $locale);

        if (!$article) {
            throw new Exception("This article doesn't exist");
        }

        return $article;
    }

    /**
     * @param string $locale
     * @return array
     */
    public function findAll(string $locale)
    {
        return $this->articleRepository->findAll($locale);
    }

    /**
     * @param string $name
     * @param string $description
     * @param string $shortDescription
     * @param string $barCode
     * @param string $internalCode
     * @param string $status
     * @param string $slug
     * @param $price
     * @param $priceCurrency
     * @param Tax|null $tax
     * @param $costPrice
     * @param Brand|null $brand
     * @param Category $category
     * @param License $license
     * @param array $tags
     * @param array $colors
     * @param array $flavours
     * @param array $allergens
     * @param array $ingredients
     * @param array $prices
     * @return Article
     */
    public function create(
        string $name,
        string $description,
        string $shortDescription,
        string $barCode,
        string $internalCode,
        string $status,
        string $slug,
        $price = null,
        $priceCurrency,
        Tax $tax = null,
        $costPrice,
        Brand $brand = null,
        Category $category,
        License $license = null,
        array $tags = [],
        array $colors = [],
        array $flavours = [],
        array $allergens = [],
        array $ingredients = [],
        array $prices = []
    ): Article {
        $article = new Article();
        $article->setName($name);
        $article->setDescription($description);
        $article->setShortDescription($shortDescription);
        $article->setBarCode($barCode);
        $article->setInternalCode($internalCode);
        $article->setStatus($status);
        $article->setSlug($slug);
        if ($status === Article::STATUS_PUBLISHED) {
            $article->setPublishedOn(new DateTime('now'));
        }
        if (count($prices) > 0 and $price == null) {
            $article->setPrice($prices);
        } elseif(count($prices) == 0 and $price != null) {
            $article->setPrice($price);
        }

        $article->setPriceCurrency($priceCurrency);
        if ($tax) {
            $article->setTax($tax);
        }
        $article->setCostPrice($costPrice);
        $article->setIngredients($ingredients);
        $article->setLicense($license);

        if ($brand) {
            $article->setBrand($brand);
        }
        $article->setCategory($category);
        $article->setTags($tags);
        $article->setColors($colors);
        $article->setFlavours($flavours);
        $article->setAllergens($allergens);

        $this->save($article);

        return $article;
    }

    /**
     * @param Article $article
     * @param string $translatedName
     * @param string $translatedDescription
     * @param string $translatedIngredients
     * @param string $locale
     */
    public function addTranslation(
        Article $article,
        string $locale,
        string $translatedName,
        string $translatedDescription,
        string $translatedIngredients
    ) {
        $article->addTranslation(new ArticleTranslation($locale, 'name', $translatedName));
        $article->addTranslation(new ArticleTranslation($locale, 'description', $translatedDescription));
        $article->addTranslation(new ArticleTranslation($locale, 'ingredients', $translatedIngredients));
        $this->save($article);
    }

    /**
     * @param Article $article
     * @return Article
     */
    public function update(Article $article)
    {
        $this->save($article);

        return $article;
    }

    /**
     * @param Article $article
     */
    public function save(Article $article)
    {
        $this->articleRepository->save($article);
    }
}
