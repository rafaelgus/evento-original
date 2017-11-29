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
    const BRANDS = 'marcas';
    const COLORS = 'colors';
    const FLAVOURS = 'sabores';

    const ATTR_PARENT = 'parent_id';

    private $articleService;
    private $allergenService;
    private $colorService;

    public function __construct(
        ArticleService $articleService,
        AllergenService $allergenService,
        ColorService $colorService
    ) {
        $this->articleService = $articleService;
        $this->allergenService = $allergenService;
        $this->colorService = $colorService;
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
        array $flavours
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
        $webCategories = $articles[self::CATEGORIES];

        $allerges = $this->syncAllergens($allergensId);
        $colors = $this->syncColors($webCategories);
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

    public function syncColors(array $webCategoriesId)
    {
        $webCategories = $this->getWebCategories();

        $colorParent = array_filter(
            $webCategories, function($webCategory) {
                return $webCategory->name = self::COLORS;
        });

        $colors = [];

        foreach ($webCategories as $webCategory) {
            if ($webCategory[self::ATTR_PARENT] == $colorParent[self::ID] and $webCategory[self::ID] == $webCategoriesId) {
                $color = $this->colorService->findOneByName($webCategory[self::NAME], App::getLocale());

                if (!$color) {
                    $color = $this->colorService->create($webCategory[self::NAME]);
                }
                $colors[] = $color;
            }
        }

        return $colors;
    }

    public function syncBrand(array $webCategoriesId)
    {

    }
}