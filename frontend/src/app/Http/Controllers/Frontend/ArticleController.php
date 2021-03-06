<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use EventoOriginal\Core\Enums\VisitorEventType;
use EventoOriginal\Core\Services\ArticleService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use EventoOriginal\Core\Persistence\Repositories\CategoryRepository;
use EventoOriginal\Core\Services\BrandService;
use EventoOriginal\Core\Services\CategoryService;
use EventoOriginal\Core\Services\ColorService;
use EventoOriginal\Core\Services\FlavourService;
use EventoOriginal\Core\Services\HealthyService;
use EventoOriginal\Core\Services\LicenseService;
use EventoOriginal\Core\Services\TagService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    const DEFAULT_ORDER_BY = 'position';

    private $articleService;
    private $categoryService;
    private $brandService;
    private $colorService;
    private $licenseService;
    private $flavourService;
    private $tagService;
    private $categoryRepository;
    private $healthyService;

    public function __construct(
        ArticleService $articleService,
        CategoryService $categoryService,
        BrandService $brandService,
        ColorService $colorService,
        LicenseService $licenseService,
        FlavourService $flavourService,
        TagService $tagService,
        CategoryRepository $categoryRepository,
        HealthyService $healthyService
    ) {
        $this->articleService = $articleService;
        $this->categoryService = $categoryService;
        $this->brandService = $brandService;
        $this->colorService = $colorService;
        $this->licenseService = $licenseService;
        $this->flavourService = $flavourService;
        $this->tagService = $tagService;
        $this->categoryRepository = $categoryRepository;
        $this->healthyService = $healthyService;
    }

    public function getHome()
    {
        $articles = array_slice($this->articleService->findAll(App::getLocale()), 0, 4);

        return view('frontend.home')
            ->with('articles', $articles);
    }

    public function index(string $categorySlug = null)
    {
        $category = $this->categoryService->findBySlug($categorySlug, App::getLocale());
        if ($category) {
            $categoryAndChildren = $this->categoryService->getChildren($category, false, null, 'ASC', true);

            $brands = $this->brandService->getByCategories($categoryAndChildren, App::getLocale());
            $colors = $this->colorService->getByCategories($categoryAndChildren, App::getLocale());
            $licenses = $this->licenseService->getByCategories($categoryAndChildren, App::getLocale());
            $flavours = $this->flavourService->getByCategories($categoryAndChildren, App::getLocale());
            $tags = $this->tagService->getByCategories($categoryAndChildren, App::getLocale());
            $healthys = $this->healthyService->getByCategories($categoryAndChildren, App::getLocale());

            return view('frontend.articles.index')
                ->with('category', $category)
                ->with('brands', $brands)
                ->with('colors', $colors)
                ->with('licenses', $licenses)
                ->with('flavours', $flavours)
                ->with('tags', $tags)
                ->with('healthys', $healthys);
        } else {
            return abort(404);
        }
    }

    public function getFilteredArticles(
        Request $request,
        string $categorySlug = null
    ) {
        $subCategories = (isset($request->subcategories) ? $request->subcategories : []);
        $brands = (isset($request->brands) ? $request->brands : []);
        $colors = (isset($request->colors) ? $request->colors : []);
        $flavours = (isset($request->flavours) ? $request->flavours : []);
        $licenses = (isset($request->licenses) ? $request->licenses : []);
        $tags = (isset($request->tags) ? $request->tags : []);
        $healthys = (isset($request->healthys) ? $request->healthys : []);
        $priceMin = (isset($request->priceMin) ? $request->priceMin : 0);
        $priceMax = (isset($request->priceMax) ? $request->priceMax : null);
        $pageLimit = (isset($request->pageLimit) ? $request->pageLimit : null);
        $page = (isset($request->limit) ? $request->limit : null);
        $orderBy = (isset($request->orderBy) ? $request->orderBy : 'position');

        $paginator = $this->articleService->getFilteredArticles(
            $categorySlug,
            $subCategories,
            $brands,
            $colors,
            $flavours,
            $licenses,
            $tags,
            $healthys,
            $priceMin,
            $priceMax,
            App::getLocale(),
            true,
            $pageLimit,
            $page,
            $orderBy
        );

        $response = [
            'total' => $paginator->count(),
            'pages' => ceil($paginator->count() / $pageLimit),
            'data' => $this->articleService->toJson($paginator->getQuery()->getResult()),
        ];

        return $response;
    }

    public function getImage(string $filename)
    {
        $image = Storage::disk('s3')->get('/images/' . $filename);

        return $image;
    }

    public function articleDetail(Request $request, $identifier)
    {
        if (is_numeric($identifier)) {
            $article = $this->articleService->findByInternalCode($identifier);
        } else {
            $article = $this->articleService->findBySlug($identifier);
        }

        if ($article) {
            if ($request->input('ref')) {
                pushVisitorEvent(
                    VisitorEventType::AFFILIATE_REFERRAL_ARRIVAL,
                    [
                        'affiliate_code_referral' => $request->input('ref'),
                        'article' => $article
                    ]
                );
            }

            return view('frontend.articles.show')
                ->with('article', $article);
        }

        return abort(404);
    }

    public function search(string $search)
    {
        $articles = $this->articleService->getPaginatedSearch($search, 5);

        $articles = $this->articleService->searchToJson($articles->getQuery()->getResult());

        return $articles;
    }

    public function getSearch(Request $request)
    {
        $page = $request->input('page');
        $search = $request->input('search');

        if (!$page) {
            $page = 1;
        }

        $actual = $page;

        $paginator = $this->articleService->getPaginatedSearch($request->input('search'), 10, $page);

        $pages = ceil($paginator->count() / 10);

        $startPage = $page;

        if (($startPage + 5) > $pages) {
            $endPage = ceil($paginator->count() / 10);
        } else {
            $endPage = $startPage + 5;
        }

        return view('frontend.articles.search')
            ->with('articles', $paginator->getQuery()->getResult())
            ->with('total', count($paginator))
            ->with('pages', $page)
            ->with('search', $search)
            ->with('actual', $actual)
            ->with('start', $startPage)
            ->with('end', $endPage);
    }
}
