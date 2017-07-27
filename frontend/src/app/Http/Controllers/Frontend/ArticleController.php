<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use EventoOriginal\Core\Services\BrandService;
use EventoOriginal\Core\Services\CategoryService;
use Illuminate\Support\Facades\App;

class ArticleController extends Controller
{
    private $categoryService;
    private $brandService;

    public function __construct(
        CategoryService $categoryService,
        BrandService $brandService
    ) {
        $this->categoryService = $categoryService;
        $this->brandService = $brandService;
    }

    public function index(string $categorySlug = null)
    {
        $category = $this->categoryService->findBySlug($categorySlug, App::getLocale());
        $brands = $this->brandService->getByCategorySlug($categorySlug, App::getLocale());

        if ($category) {
            return view('frontend.articles.index')
                ->with('category', $category)
                ->with('brands', $brands);
        } else {
            return abort(404);
        }
    }
}
