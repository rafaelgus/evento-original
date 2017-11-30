<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Brand;
use EventoOriginal\Core\Entities\Category;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;

class OdooService
{
    const BASE_URL = 'http://alfonso.romilax.com:8070';
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
        $uri =  "/api/product.template/search?token". $token ."=&domain=[('sale_ok','=', True),('rm_sync','=', False)]&limit=10000&fields=['name','default_code','type','categ_id','pos_categ_id','rm_sync','product_id']";

        $articles = $this->connect(self::HTTP_METHOD_GET, $uri);

        return json_decode($articles, true);
    }

    public function SyncArticle(int $articleId)
    {
        $uri = "/api/product.template/update/". $articleId ."?token=". $this->getToken() ."&update_vals={'rm_sync':'True'}";

        $response = $this->connect(self::HTTP_METHOD_GET, $uri);

        if ($response->getStatusCode() === self::STATUS_CODE_OK) {
            return true;
        } else {
            return false;
        }
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

        $uri = "http://alfonso.romilax.com:8070/api/product.public.category/search?token=". $token."&domain=[('id','=',". $id. ")]&limit=10000&fields=['id','name','parent_id']";

        $webCategory = $this->connect(self::HTTP_METHOD_GET, $uri);

        return json_decode($webCategory, true);
    }

    public function getAllergens()
    {
        $token = $this->getToken();

        $uri = "http://alfonso.romilax.com:8070/api/rm.productos.tipo.alergenos/search?token=". $token ."&domain=[]&limit=10000&fields=['rm_nombre']";

        $allergens = $this->connect(self::HTTP_METHOD_GET, $uri);

        return json_decode($allergens, true);
    }

    public function buildArticle(
        array $data,
        array $colors,
        Brand $brand,
        array $allergens,
        Category $category,
        array $flavours,
        array $tags
    ) {
        $article = $this
            ->articleService
            ->create(
                $data[self::NAME],
                'description',
                'description',
                self::BARCODE,
                self::DEFAULT_CODES,
                'new',
                $data[self::NAME],
                $data[self::LIST_PRICE],
                'type',
                '0',
                null,
                $data[self::LIST_PRICE],
                $brand,
                $category,
                null,
                null,
                $colors,
                $flavours,
                $allergens,
                null,
                null,
                null,
                true
            );

        return $article;
    }

    public function syncArticles()
    {
        $articles = $this->getNotSyncArticles();

        $allergensId = $articles[self::ALLERGENS];

        $webCategoriesId = $articles[self::CATEGORIES];

        if (count($allergensId) == 0 and count($webCategoriesId) == 0) {
            return;
        }

        $allergens = $this->syncAllergens($allergensId);
        $categories = $this->syncWebCategories($webCategoriesId);

        $category =  $this->categoryService->findOneById(1, App::getLocale());
        $brand = $this->brandService->findOneById(1);

        foreach ($articles as $article) {
            $this->buildArticle(
                $article,
                $categories['colors'],
                $brand,
                $allergens,
                $category,
                $categories['flavours'],
                $categories['tags']
            );
        }
    }

    public function syncAllergens(array $allergensId)
    {
        $odooAllergens = $this->getAllergens();

        $allergens = [];

        foreach ($odooAllergens as $odooAllergen) {
            if(in_array($odooAllergen[self::ID], $allergensId)) {
                $allergen = $this->allergenService->findByName($odooAllergen[self::NAME]);

                if (!$allergen) {
                    $allergen = $this->allergenService->create($odooAllergen[self::NAME]);
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
            if ($webCategory[self::ATTR_PARENT] == $colorParent[self::ID]) {
                if (in_array($webCategory[self::ID], $webCategoriesId)) {
                    $color = $this->colorService->findOneByName($webCategory[self::NAME], App::getLocale());

                    if (!$color) {
                        $color = $this->colorService->create($webCategory[self::NAME]);
                    }
                    $categories['colors'] = $color;
                } elseif ($webCategory[self::ATTR_PARENT] == $flavoursParent[self::ID]) {
                    if (in_array($webCategory[self::ID], $webCategoriesId)) {
                        $flavour = $this->flavourService->findOneByName($webCategory[self::NAME], App::getLocale());

                        if (!$flavour) {
                            $flavour = $this->flavourService->create($webCategory[self::NAME]);
                        }
                        $categories['flavours'] = $flavour;
                    }
                } elseif ($webCategory[self::ATTR_PARENT] == $typeParent[self::ID] or
                    $webCategory[self::ATTR_PARENT] == $otherParents[self::ID]) {
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
            return $webCategory->name == self::COLORS;
        });

        return $colorParent;
    }

    public function getFlavoursParent(array $webCategories)
    {
        $flavour = array_filter(
            $webCategories, function($webCategory) {
            return $webCategory->name == self::FLAVOURS;
        });

        return $flavour;
    }

    public function getTypeParent(array $webCategories)
    {
        $type = array_filter(
            $webCategories, function($webCategory) {
            return $webCategory->name == self::FLAVOURS;
        });

        return $type;
    }

    public function getOtherParents(array $webCategories)
    {
        $others = array_filter(
            $webCategories, function($webCategory) {
                return $webCategory->name == self::OTHER;
        });

        return $others;
    }
}