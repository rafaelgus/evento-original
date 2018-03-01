<?php

namespace EventoOriginal\Core\Services;

use DateTime;
use EventoOriginal\Core\Entities\Article;
use EventoOriginal\Core\Entities\ArticleTranslation;
use EventoOriginal\Core\Entities\Brand;
use EventoOriginal\Core\Entities\Category;
use EventoOriginal\Core\Entities\Design;
use EventoOriginal\Core\Entities\License;
use EventoOriginal\Core\Entities\Tax;
use EventoOriginal\Core\Persistence\Repositories\ArticleRepository;
use Exception;
use InvalidArgumentException;

class ArticleService
{
    const DEFAULT_LOCALE = 'es';

    private $articleRepository;
    private $categoryService;
    /**
     * @var ImageService
     */
    private $imageService;

    public function __construct(
        ArticleRepository $articleRepository,
        CategoryService $categoryService,
        ImageService $imageService
    ) {
        $this->articleRepository = $articleRepository;
        $this->categoryService = $categoryService;
        $this->imageService = $imageService;
    }

    /**
     * @param int $id
     * @param string $locale
     * @return Article
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
     * @param string $priceType
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
        int $price,
        string $priceType,
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
        array $prices = [],
        array $healthys = [],
        bool $isNew = true
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
        } elseif (count($prices) == 0 and $price != null) {
            $article->setPrice($price);
        }

        $article->setPriceCurrency($priceCurrency);
        if ($tax) {
            $article->setTax($tax);
        }
        $article->setCostPrice($costPrice);
        $article->setIngredients($ingredients);
        if ($license) {
            $article->setLicense($license);
        }
        $article->setPriceType($priceType);

        if ($brand) {
            $article->setBrand($brand);
        }
        $article->setCategory($category);
        $article->setTags($tags);
        $article->setColors($colors);
        $article->setFlavours($flavours);
        $article->setAllergens($allergens);
        $article->setHealthys($healthys);
        $article->setIsNew($isNew);

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
        return $this->articleRepository->save($article);
    }


    public function findAllPaginated(int $currentPage = 1, int $maxItems = 10)
    {
        return $this->articleRepository->findAllPaginated($currentPage, $maxItems);
    }

    /**
     * @param string $slug
     * @return null|Article
     */
    public function findBySlug(string $slug)
    {
        return $this->articleRepository->findBySlug($slug);
    }

    /**
     * @param string $categorySlug
     * @param array $subCategories
     * @param array $brands
     * @param array $colors
     * @param array $flavours
     * @param array $licenses
     * @param array $tags
     * @param array $healtyhs
     * @param float|null $priceMin
     * @param float|null $priceMax
     * @param string $locale
     * @param bool $paginate
     * @param int|null $pageLimit
     * @param int|null $page
     * @param string $orderBy
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getFilteredArticles(
        string $categorySlug,
        array $subCategories,
        array $brands,
        array $colors,
        array $flavours,
        array $licenses,
        array $tags,
        array $healtyhs,
        float $priceMin = null,
        float $priceMax = null,
        string $locale = 'es',
        bool $paginate = false,
        ?int $pageLimit = 9,
        ?int $page = 1,
        string $orderBy = 'position'
    ) {
        $category = $this->categoryService->findBySlug($categorySlug);
        $categories = $this->categoryService->getChildren($category, false, null, 'ASC', true);

        if (count($subCategories) > 0) {
            $categories = [];
            foreach ($subCategories as $subCategory) {
                $c = $this->categoryService->findOneById($subCategory, $locale);
                $categories = array_merge(
                    $categories,
                    $this->categoryService->getChildren($c, false, null, 'ASC', true)
                );
            }
        }

        if ($category) {
            return $this->articleRepository->getFilteredArticles(
                $categories,
                $brands,
                $colors,
                $flavours,
                $licenses,
                $tags,
                $healtyhs,
                $priceMin,
                $priceMax,
                $locale,
                $paginate,
                $pageLimit,
                $page,
                $orderBy
            );
        }

        throw new InvalidArgumentException("Invalid category slug");
    }

    public function toJson(array $articles)
    {
        $articlesArray = [];
        $now = new DateTime('now');
        foreach ($articles as $article) {
            $interval = date_diff($now, $article->getCreated());

            $articlesArray[] = [
                'name' => $article->getName(),
                'slug' => $article->getSlug(),
                'price' => $article->getPrice(),
                'price_currency' => '€',
                'rating' => 4,
                'isNew' => ($article->isNew() || $interval->format('%a') <= 15),
                'image' => (count($article->getImages()) > 0) ? $article->getImages()->toArray()[0]->getPath() : ''
            ];
        }

        return json_encode($articlesArray);
    }

    public function findByCategorySlug(string $categorySlug)
    {
        $category = $this->categoryService->findBySlug($categorySlug);

        if ($category) {
            return $this->articleRepository->findByCategory($category);
        } else {
            throw new InvalidArgumentException("Invalid category slug");
        }
    }

    /**
     * @param string $barCode
     * @return null|Article
     */
    public function findByBarcode(string $barCode)
    {
        return $this->articleRepository->findOneByBarCode($barCode);
    }

    public function createFromDesign(Design $design)
    {
        $article = new Article();
        $article->setName($design->getName());
        $article->setDescription($design->getDescription());
        $article->setShortDescription($design->getDescription());
        $article->setStatus(Article::STATUS_PUBLISHED);
        $article->setSlug(str_slug($design->getName()));
        $article->setPublishedOn(new DateTime('now'));
        $article->setBarCode(uniqid());
        $article->setInternalCode(uniqid());
        $article->setDesign($design);

        if ($design->getCircularDesignVariant()) {
            $variant = $design->getCircularDesignVariant();

            $detail = $variant->getDefaultDetail();

            $costPrice = 0;
            if ($detail) {
                $costPrice = $detail->getBasePrice();
            }

            $price = $costPrice + ($costPrice * ($design->getCommission() / 100));

            $article->setPrice($price);
            $article->setCostPrice($costPrice);

            if ($variant->getCategory()) {
                $article->setCategory($variant->getCategory());
            }
        }

        $article->setPriceCurrency('EUR');
        $article->setPriceType('unit');

        $this->save($article);

        $image = $this->imageService->create($design->getImage(), $design->getDescription(), $article);
        $article->addImage($image);

        return $this->save($article);
    }

    /**
     * @param string $internalCode
     * @return null|Article
     */
    public function findByInternalCode(string $internalCode)
    {
        return $this->articleRepository->findOneByInternalCode($internalCode);
    }
}
