<?php
namespace App\Http\Controllers\Backend;

use App\Jobs\SyncArticles;
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
        $articles = $this->odooService->getNotSyncArticles();

        return view('backend.admin.odoo.sync')
            ->with('total', count($articles));
    }

    public function syncArticles()
    {
        $articles = $this->odooService->getNotSyncArticles();

        foreach ($articles as $article) {
            SyncArticles::dispatch($article);
        }

        return ['message' => 'Se sincronizaran los articulos'];
    }
}