<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use EventoOriginal\Core\Services\ArticleService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function getHome()
    {
        $articles = $this->articleService->findAll(App::getLocale());

        return view('frontend.home')
            ->with('articles', $articles);
    }

    public function index(string $categorySlug = null)
    {
        $articles = $this->articleService->findAll(App::getLocale());

        if ($categorySlug) {
            return view('frontend.articles.index')
                ->with(['articles' => $articles]);
        }

        return view('frontend.home')
            ->with('articles', $articles);
    }

    public function getImage(string $filename)
    {
        $image = Storage::disk('s3')->get('/images/'. $filename);

        return $image;
    }

    public function articleDetail(string $slug)
    {
        $article = $this->articleService->findBySlug($slug);

        return view('frontend.articles.show')
            ->with('article', $article);
    }
}
