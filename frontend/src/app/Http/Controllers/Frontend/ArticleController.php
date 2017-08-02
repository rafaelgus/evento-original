<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use DoctrineProxies\__CG__\EventoOriginal\Core\Entities\Flavour;
use EventoOriginal\Core\Services\ArticleService;
use EventoOriginal\Core\Services\BrandService;
use EventoOriginal\Core\Services\CategoryService;
use EventoOriginal\Core\Services\ColorService;
use EventoOriginal\Core\Services\FlavourService;
use EventoOriginal\Core\Services\LicenseService;
use Illuminate\Support\Facades\App;

class ArticleController extends Controller
{
    private $articleService;
    private $categoryService;
    private $brandService;
    private $colorService;
    private $licenseService;
    private $flavourService;

    public function __construct(
        ArticleService $articleService,
        CategoryService $categoryService,
        BrandService $brandService,
        ColorService $colorService,
        LicenseService $licenseService,
        FlavourService $flavourService
    ) {
        $this->articleService = $articleService;
        $this->categoryService = $categoryService;
        $this->brandService = $brandService;
        $this->colorService = $colorService;
        $this->licenseService = $licenseService;
        $this->flavourService = $flavourService;
    }

    public function index(string $categorySlug = null)
    {
        $brands = [];

        $articles = $this->articleService->getFilteredArticles($categorySlug, $brands);
        $category = $this->categoryService->findBySlug($categorySlug, App::getLocale());
        $brands = $this->brandService->getByCategorySlug($categorySlug, App::getLocale());
        $colors = $this->colorService->getByCategorySlug($categorySlug, App::getLocale());
        $licenses = $this->licenseService->getByCategorySlug($categorySlug, App::getLocale());
        $flavours = $this->flavourService->findAll(App::getLocale());

        if ($category) {
            return view('frontend.articles.index')
                ->with('articles', $articles)
                ->with('category', $category)
                ->with('brands', $brands)
                ->with('colors', $colors)
                ->with('licenses', $licenses)
                ->with('flavours', $flavours);
        } else {
            return abort(404);
        }
    }
}
