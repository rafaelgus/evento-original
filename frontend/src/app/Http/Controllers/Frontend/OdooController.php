<?php
namespace App\Http\Controllers\Frontend;

use EventoOriginal\Core\Services\OdooService;

class OdooController
{
    private $odooService;

    public function __construct(OdooService $odooService)
    {
        $this->odooService = $odooService;
    }


    public function showNotSyncArticles()
    {
        $this->odooService->syncArticles();
    }
}