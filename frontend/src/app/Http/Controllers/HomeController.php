<?php

namespace App\Http\Controllers;

use EventoOriginal\Core\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
        $this->middleware('auth');
    }

    public function index()
    {
        $articles = $this->articleService->findAll(App::getLocale());

        return view('fronted.home')->with('articles', $articles);
    }
}
