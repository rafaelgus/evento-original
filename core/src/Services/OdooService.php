<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Brand;
use EventoOriginal\Core\Entities\Category;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;

class OdooService
{
    const BASE_URL = 'http://alfonso.movilcrm.com:8070';
    const EMAIL = 'rest@gmail.com';
    const PASSWORD = '123456';

    const HTTP_METHOD_POST = 'POST';
    const HTTP_METHOD_GET = 'GET';

    const STATUS_CODE_OK = 200;

    //article attributes
    const INGREDIENTS = 'rm_ingredientes';
    const LIST_PRICE = 'list_price';
    const NAME = 'name';
    const CATEGORIES = 'public_categ_ids';
    const BARCODE = 'barcode';
    const ALLERGENS = 'rm_alergenos';
    const DEFAULT_CODES = 'default_code';
    const POS_CATEGORIES = 'pos_categ_id';
    const ID = 'id';

    //web categories
    const BRANDS = 'MARCAS';
    const COLORS = 'COLOR';
    const FLAVOURS = 'SABOR';
    const TYPE = 'TIPO';
    const OTHER = 'OTROS';

    const ATTR_PARENT = 'parent_id';

    private $articleService;
    private $allergenService;
    private $flavourService;
    private $colorService;
    private $tagService;
    private $categoryService;
    private $brandService;

    public function __construct(
        ArticleService $articleService,
        AllergenService $allergenService,
        ColorService $colorService,
        FlavourService $flavourService,
        TagService $tagService,
        CategoryService $categoryService,
        BrandService $brandService
    ) {
        $this->articleService = $articleService;
        $this->allergenService = $allergenService;
        $this->colorService = $colorService;
        $this->flavourService = $flavourService;
        $this->tagService = $tagService;
        $this->categoryService = $categoryService;
        $this->brandService = $brandService;
    }

    public function connect(string $method, string $parameterUrl, string $data = '')
    {
        $client = new Client([
            'base_uri' => self::BASE_URL,
            'Content-Type' => 'text/html; charset=utf-8',
        ]);
        $response = $client->request($method, $parameterUrl);

        $response = $response->getBody()->getContents();

        return $response;
    }

    private function getToken()
    {
        $uri = '/api/user/get_token?login=' . self::EMAIL . '&password='. self::PASSWORD;

        $response = json_decode($this->connect(self::HTTP_METHOD_GET, $uri), true);

        return $response['token'];
    }

    public function getNotSyncArticles()
    {
        $token = $this->getToken();
        $uri =  "/api/product.template/search?token". $token ."=&domain=[('sale_ok','=', True),('rm_sync','=', False)]&limit=10000&fields=['name','type','default_code','public_categ_ids','barcode','list_price','rm_ingredientes','rm_alergenos','rm_sync','qty_available']";

        $articles = $this->connect(self::HTTP_METHOD_GET, $uri);

        return json_decode($articles, true);
    }


    public function getSyncArticles()
    {
        $token = $this->getToken();
        $uri =  "/api/product.template/search?token". $token ."=&domain=[('sale_ok','=', True),('rm_sync','=', False)]&limit=10000&fields=['name','default_code','type','categ_id','pos_categ_id','rm_sync','product_id']";

        $articles = $this->connect(self::HTTP_METHOD_GET, $uri);

        return json_decode($articles, true);
    }

    public function getAllergen()
    {
        $token = $this->getToken();
        $uri = "/api/rm.productos.tipo.alergenos/search?token=".$token."&domain=[]&limit=10000&fields=['rm_nombre']";

        $allergens = $this->connect(self::HTTP_METHOD_GET, $uri);

        return json_decode($allergens, true);
    }

    public function getWebCategories()
    {
        $token = $this->getToken();
        $uri = "/api/product.public.category/search?token=".$token."&domain=[]&limit=10000&fields=['name','parent_id']";

        $webCategories =  $this->connect(self::HTTP_METHOD_GET, $uri);

        return json_decode($webCategories, true);
    }

    public function getWebCategoryById(int $id)
    {
        $token = $this->getToken();

        $uri = "http://alfonso.movilcrm.com:8070/api/product.public.category/search?token=". $token."&domain=[('id','=',". $id. ")]&limit=10000&fields=['id','name','parent_id']";

        $webCategory = $this->connect(self::HTTP_METHOD_GET, $uri);

        return json_decode($webCategory, true);
    }

    public function getAllergens()
    {
        $token = $this->getToken();

        $uri = "http://alfonso.movilcrm.com:8070/api/rm.productos.tipo.alergenos/search?token=". $token ."&domain=[]&limit=10000&fields=['rm_nombre']";

        $allergens = $this->connect(self::HTTP_METHOD_GET, $uri);

        return json_decode($allergens, true);
    }

    public function buildArticle(
        array $data,
        array $colors,
        Brand $brand,
        array $allergens,
        Category $category,
        array $flavours = [],
        array $tags = []
    ) {
        $article = $this
            ->articleService
            ->create(
                $data[self::NAME],
                'description',
                'description',
                $data[self::BARCODE],
                $data[self::DEFAULT_CODES],
                'draft',
                str_slug($data[self::NAME]),
                $data[self::LIST_PRICE],
                'type',
                '0',
                null,
                $data[self::LIST_PRICE],
                $brand,
                $category,
                null,
                $tags,
                $colors,
                $flavours,
                $allergens,
                [],
                [],
                [],
                true
            );
        $this->articleService->save($article);

        return $article;
    }

    public function syncArticles()
    {
        $articles = $this->getNotSyncArticles();

        foreach ($articles as $article) {
            $webCategoriesId = $article[self::CATEGORIES];
            $allergensId = $article[self::ALLERGENS];

            if (count($webCategoriesId) != 0) {
                $allergens = $this->syncAllergens($allergensId);

                $categories = $this->syncWebCategories($webCategoriesId);

                if (count($categories) > 0) {
                    $category =  $this->syncCategories($article[self::POS_CATEGORIES][0]);
                    $brand = $this->brandService->findOneById(1);

                    $color = [];
                    $flavours = [];
                    $tag = [];

                    if (array_key_exists('colors', $categories)) {
                        $color[] = $categories['colors'];
                    }
                    if (array_key_exists('flavours', $categories)) {
                        $flavours[] = $categories['flavours'];
                    }
                    if (array_key_exists('tags', $categories)) {
                        $tag[] = $categories['tags'];
                    }

                    $this->buildArticle(
                        $article,
                        $color,
                        $brand,
                        $allergens,
                        $category,
                        $flavours,
                        $tag
                    );

                    $this->setSync($article[self::ID]);
                }
            }
        }
    }

    public function syncArticle(array $odooArticle)
    {
        $article = $this->articleService->findByBarcode($odooArticle[self::BARCODE]);

        if ($article) {
            $this->updateArticle($odooArticle);
        } else {
            $webCategoriesId = $odooArticle[self::CATEGORIES];
            $allergensId = $odooArticle[self::ALLERGENS];

            if (count($webCategoriesId) != 0) {
                $allergens = $this->syncAllergens($allergensId);

                $categories = $this->syncWebCategories($webCategoriesId);

                if (count($categories) > 0) {
                    $category =  $this->syncCategories($odooArticle[self::POS_CATEGORIES][0]);
                    $brand = $this->brandService->findOneById(1);

                    $color = [];
                    $flavours = [];
                    $tag = [];

                    if (array_key_exists('colors', $categories)) {
                        $color[] = $categories['colors'];
                    }
                    if (array_key_exists('flavours', $categories)) {
                        $flavours[] = $categories['flavours'];
                    }
                    if (array_key_exists('tags', $categories)) {
                        $tag[] = $categories['tags'];
                    }

                    $this->buildArticle(
                        $odooArticle,
                        $color,
                        $brand,
                        $allergens,
                        $category,
                        $flavours,
                        $tag
                    );

                    $this->setSync($odooArticle[self::ID]);
                }
            }
        }
    }

    public function syncAllergens(array $allergensId)
    {
        $odooAllergens = $this->getAllergens();

        $allergens = [];
        foreach ($odooAllergens as $odooAllergen) {
            if(in_array($odooAllergen[self::ID], $allergensId)) {
                $allergen = $this->allergenService->findByName($odooAllergen['rm_nombre']);

                if (!$allergen) {
                    $allergen = $this->allergenService->create($odooAllergen['rm_nombre']);
                }
                $allergens[] = $allergen;
            }
        }
        return $allergens;
    }

    public function syncWebCategories(array $webCategoriesId)
    {
        $webCategories = $this->getWebCategories();

        $colorParent = $this->getColorParents($webCategories);
        $flavoursParent = $this->getFlavoursParent($webCategories);
        $typeParent = $this->getTypeParent($webCategories);
        $otherParents = $this->getOtherParents($webCategories);

        $categories = [];

        foreach ($webCategories as $webCategory) {
            if ($webCategory[self::ATTR_PARENT] != false) {
                if ($webCategory[self::ATTR_PARENT][0] == $colorParent[self::ID]) {
                    if (in_array($webCategory[self::ID], $webCategoriesId)) {
                        $color = $this->colorService->findOneByName($webCategory[self::NAME], App::getLocale());

                        if (!$color) {
                            $color = $this->colorService->create($webCategory[self::NAME]);
                        }
                        $categories['colors'] = $color;
                    }
                } elseif ($webCategory[self::ATTR_PARENT][0] == $flavoursParent[self::ID]) {
                    if (in_array($webCategory[self::ID], $webCategoriesId)) {
                        $flavour = $this->flavourService->findOneByName($webCategory[self::NAME], App::getLocale());

                        if (!$flavour) {
                            $flavour = $this->flavourService->create($webCategory[self::NAME]);
                        }
                        $categories['flavours'] = $flavour;
                    }
                } elseif ($webCategory[self::ATTR_PARENT][0] == $typeParent[self::ID] or
                    $webCategory[self::ATTR_PARENT][0] == $otherParents[self::ID]) {
                    if (in_array($webCategory[self::ID], $webCategoriesId)) {
                        $tag = $this->tagService->findOneByName($webCategory[self::NAME], App::getLocale());

                        if (!$tag) {
                            $tag = $this->tagService->create($webCategory[self::NAME]);
                        }
                        $categories['tags'] = $tag;
                    }
                }
            }
        }
        return $categories;
    }

    public function getColorParents(array $webCategories)
    {
        $colorParent = array_filter(
            $webCategories, function($webCategory) {
            return $webCategory[self::NAME] == self::COLORS;
        });

        return array_first($colorParent);
    }

    public function getFlavoursParent(array $webCategories)
    {
        $flavour = array_filter(
            $webCategories, function($webCategory) {
            return $webCategory[self::NAME] == self::FLAVOURS;
        });

        return array_first($flavour);
    }

    public function getTypeParent(array $webCategories)
    {
        $type = array_filter(
            $webCategories, function($webCategory) {
            return $webCategory[self::NAME] == self::FLAVOURS;
        });

        return array_first($type);
    }

    public function getOtherParents(array $webCategories)
    {
        $others = array_filter(
            $webCategories, function($webCategory) {
                return $webCategory[self::NAME] == self::OTHER;
        });

        return array_first($others);
    }

    public function setSync(int $articleId)
    {
        $token = $this->getToken();

        $uri = "/api/product.template/update/". $articleId ."?token=". $token ."&update_vals={'rm_sync':'True'}";

        $this->connect(self::HTTP_METHOD_GET, $uri);
    }

    public function getCategory(int $categoryId)
    {
        $token = $this->getToken();

        $uri = "/api/pos.category/search?token=". $token ."&domain=[('id','=',". $categoryId. ")]&limit=10000&fields=['id','name','parent_id']";

        $odooCategory = $this->connect(self::HTTP_METHOD_GET, $uri);

        return $odooCategory;
    }

    public function syncCategories(int $categoryId)
    {
        $odooCategory = $this->getCategory($categoryId);

        $category = $this->categoryService->findByName($odooCategory[self::NAME]);

        if (!$category) {
            if (!$odooCategory[self::ATTR_PARENT]) {
                $category = $this
                    ->categoryService
                    ->create(
                        $odooCategory[self::NAME],
                        str_slug($odooCategory[self::NAME]),
                        ''
                    );

                return $category;
            } else {
                $odooCategoryParent = $this->getCategory($odooCategory[self::ATTR_PARENT][0]);

                $categoryParent = $this->categoryService->findByName($odooCategory[self::NAME]);

                if (!$categoryParent) {
                    $categoryParent = $this
                        ->categoryService
                        ->create(
                            $odooCategoryParent[self::NAME],
                            str_slug($odooCategoryParent[self::NAME]),
                            ''
                        );
                } else {
                    $category = $this->categoryService->createChildren(
                        $categoryParent,
                        $odooCategory[self::NAME],
                        str_slug($odooCategory[self::NAME]),
                        ''
                    );

                    return $category;
                }
            }
        }

        return $category;
    }

    public function updateArticle(array $odooArticle)
    {
        $article = $this->articleService->findByBarcode($odooArticle[self::BARCODE]);

        $webCategoriesId = $odooArticle[self::CATEGORIES];
        $allergens = $this->syncAllergens($odooArticle[self::ALLERGENS]);

        if (count($webCategoriesId) > 0) {
            $webCategories = $this->syncWebCategories($odooArticle[self::CATEGORIES]);
        }
        $color = [];
        $flavours = [];
        $tag = [];

        if (array_key_exists('colors', $webCategories)) {
            $color[] = $webCategories['colors'];
        }
        if (array_key_exists('flavours', $webCategories)) {
            $flavours[] = $webCategories['flavours'];
        }
        if (array_key_exists('tags', $webCategories)) {
            $tag[] = $webCategories['tags'];
        }
        $article->setColors($color);
        $article->setFlavours($flavours);
        $article->setTags($tag);
        $article->setPrice($odooArticle[self::LIST_PRICE] * 100);
        $article->setName($odooArticle[self::NAME]);
        $article->setSlug(str_slug($odooArticle[self::NAME]));
        $article->setAllergens($allergens);


        $this->articleService->update($article);

        $this->setSync($odooArticle[self::ID]);
    }

    public function createUser()
    {

    }
}