<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use DoctrineProxies\__CG__\EventoOriginal\Core\Entities\Flavour;
use EventoOriginal\Core\Persistence\Repositories\CategoryRepository;
use EventoOriginal\Core\Services\ArticleService;
use EventoOriginal\Core\Services\BrandService;
use EventoOriginal\Core\Services\CategoryService;
use EventoOriginal\Core\Services\ColorService;
use EventoOriginal\Core\Services\FlavourService;
use EventoOriginal\Core\Services\LicenseService;
use EventoOriginal\Core\Services\TagService;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ArticleController extends Controller
{
    private $articleService;
    private $categoryService;
    private $brandService;
    private $colorService;
    private $licenseService;
    private $flavourService;
    private $tagService;
    private $categoryRepository;

    public function __construct(
        ArticleService $articleService,
        CategoryService $categoryService,
        BrandService $brandService,
        ColorService $colorService,
        LicenseService $licenseService,
        FlavourService $flavourService,
        TagService $tagService,
        CategoryRepository $categoryRepository
    ) {
        $this->articleService = $articleService;
        $this->categoryService = $categoryService;
        $this->brandService = $brandService;
        $this->colorService = $colorService;
        $this->licenseService = $licenseService;
        $this->flavourService = $flavourService;
        $this->tagService = $tagService;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(string $categorySlug = null)
    {
        $category = $this->categoryService->findBySlug($categorySlug, App::getLocale());
        $brands = $this->brandService->getByCategorySlug($categorySlug, App::getLocale());
        $colors = $this->colorService->getByCategorySlug($categorySlug, App::getLocale());
        $licenses = $this->licenseService->getByCategorySlug($categorySlug, App::getLocale());
        $flavours = $this->flavourService->getByCategorySlug($categorySlug, App::getLocale());
        $tags = $this->tagService->getByCategorySlug($categorySlug, App::getLocale());

        if ($category) {
            return view('frontend.articles.index')
                ->with('category', $category)
                ->with('brands', $brands)
                ->with('colors', $colors)
                ->with('licenses', $licenses)
                ->with('flavours', $flavours)
                ->with('tags', $tags);
        } else {
            return abort(404);
        }
    }

    public function getFilteredArticles(Request $request, string $categorySlug = null)
    {
        $subCategories = (isset($request->subcategories) ? $request->subcategories : []);
        $brands = (isset($request->brands) ? $request->brands : []);
        $colors = (isset($request->colors) ? $request->colors : []);
        $flavours = (isset($request->flavours) ? $request->flavours : []);
        $licenses = (isset($request->licenses) ? $request->licenses : []);
        $tags = (isset($request->tags) ? $request->tags : []);
        $priceMin = 0;
        $priceMax = 99999;

        $articles = $this->articleService->getFilteredArticles(
            $categorySlug,
            $subCategories,
            $brands,
            $colors,
            $flavours,
            $licenses,
            $tags,
            $priceMin,
            $priceMax
        );

        return $this->articleService->toJson($articles);
    }
}
