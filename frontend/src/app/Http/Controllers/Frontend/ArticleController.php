<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index(string $categorySlug = null)
    {
        if ($categorySlug) {
            return view('frontend.articles.index');
        }

        return view('frontend.home');
    }
}
