<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use EventoOriginal\Core\Services\CategoryService;
use Illuminate\Support\Facades\App;

class ArticleController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(string $categorySlug = null)
    {
        $category = $this->categoryService->findBySlug($categorySlug, App::getLocale());

        if ($category) {
            return view('frontend.articles.index')->with('category', $category);
        } else {
            return abort(404);
        }
    }
}
