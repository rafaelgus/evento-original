<?php

namespace App\Jobs;

use EventoOriginal\Core\Services\OdooService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SyncArticles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $article;

    /**
     * Create a new job instance.
     * @param $article
     */
    public function __construct(array $article)
    {
        $this->article = $article;
    }

    /**
     * Execute the job.
     *
     * @param $odooService OdooService
     * @return void
     */
    public function handle(OdooService $odooService)
    {
        $odooService->syncArticle($this->article);
    }
}
