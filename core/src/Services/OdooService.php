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
                $data[self::NAME],
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
                    $category =  $this->categoryService->findOneById(1, App::getLocale());
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

    public function syncArticle(array $article)
    {
        $webCategoriesId = $article[self::CATEGORIES];
        $allergensId = $article[self::ALLERGENS];

        if (count($webCategoriesId) != 0) {
            $allergens = $this->syncAllergens($allergensId);

            $categories = $this->syncWebCategories($webCategoriesId);

            if (count($categories) > 0) {
                $category =  $this->categoryService->findOneById(1, App::getLocale());
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

                //$this->setSync($article[self::ID]);
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

    public function handle()
    {

    }
}