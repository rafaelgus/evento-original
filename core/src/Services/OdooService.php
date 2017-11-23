<?php
namespace EventoOriginal\Core\Services;

use GuzzleHttp\Client;

class OdooService
{
    const BASE_URL = 'http://alfonso.romilax.com:8070';
    const EMAIL = 'rest@gmail.com';
    const PASSWORD = '123456';

    const HTTP_METHOD_POST = 'POST';
    const HTTP_METHOD_GET = 'GET';

    const STATUS_CODE_OK = 200;

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

        return json_decode($allergens);
    }

    public function getWebCategories()
    {
        $token = $this->getToken();
        $uri = "/api/product.public.category/search?token=".$token."&domain=[]&limit=10000&fields=['name','parent_id']";

        $webCategories =  $this->connect(self::HTTP_METHOD_GET, $uri);

        return json_decode($webCategories);
    }
    

}