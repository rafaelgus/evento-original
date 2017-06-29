<?php
namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\StoreArticleRequest;
use App\Http\Requests\Backend\UpdateCategoryRequest;
use EventoOriginal\Core\Services\AllergenService;
use EventoOriginal\Core\Services\ArticleService;
use EventoOriginal\Core\Services\CategoryService;
use EventoOriginal\Core\Services\ColorService;
use EventoOriginal\Core\Services\FlavourService;
use EventoOriginal\Core\Services\TagService;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Yajra\Datatables\Datatables;

class ArticleController
{
    const ARTICLE_CREATE_ROUTE = '/management/articles/create';

    protected $articleService;
    protected $categoryService;
    protected $colorService;
    protected $tagsService;
    protected $allergenService;
    protected $flavourService;

    public function __construct(
        ArticleService $articleService,
        CategoryService $categoryService,
        TagService $tagService,
        ColorService $colorService,
        AllergenService $allergenService,
        FlavourService $flavourService
    ) {
        $this->articleService = $articleService;
        $this->categoryService = $categoryService;
        $this->tagsService = $tagService;
        $this->flavourService = $flavourService;
        $this->colorService = $colorService;
        $this->allergenService = $allergenService;
    }

    public function index()
    {
        return view('backend.admin.articles.index');
    }

    public function create()
    {
        return view('backend.admin.articles.create');
    }

    public function store(StoreArticleRequest $request)
    {
        $allergens = $this
            ->allergenService
            ->findByIds(
                $request->input('allergens')
            );

        $tags = $this
            ->tagsService
            ->findByIds(
                $request->input('tags')
            );

        $colors = $this
            ->colorService
            ->findByIds(
                $request->input('tags')
            );

        $flavours = $this
            ->flavourService
            ->findByIds(
                $request->input('flavours')
            );

        $category = $this
            ->categoryService
            ->findOneById(
                $request->input('category'),
                    App::getLocale()
            );

        $data = $request->all();
        $this->articleService->create(
            $data['name'],
            $data['description'],
            $data['barCode'],
            $data['internalCode'],
            $data['status'],
            $data['slug'],
            $data['price'],
            $data['currency'],
            null,
            $data['costPrice'],
            $data['ingredients'],
            null,
            $category,
            $tags,
            $colors,
            $flavours,
            $allergens
        );

        Session::flash('message', trans('backend/messages.confirmation.create.article'));

        return redirect()->to(self::ARTICLE_CREATE_ROUTE);
    }

    public function update(int $id, UpdateCategoryRequest $request)
    {
        $article = $this->articleService->findOneById($id, App::getLocale());

        $allergens = $this
            ->allergenService
            ->findByIds(
                $request->input('allergens')
            );

        $tags = $this
            ->tagsService
            ->findByIds(
                $request->input('tags')
            );

        $colors = $this
            ->colorService
            ->findByIds(
                $request->input('tags')
            );

        $flavours = $this
            ->flavourService
            ->findByIds(
                $request->input('flavours')
            );

        $category = $this
            ->categoryService
            ->findOneById(
                $request->input('category'),
                App::getLocale()
            );

        $article->setAllergen($allergens);
        $article->setColors($colors);
        $article->setFlavours($flavours);
        $article->setTags($tags);
        $article->setCategory($category);
        $article->setName($request->input('name'));
        $article->setDescription($request->input('description'));
        $article->setBarCode($request->input('barCode'));
        $article->setPrice($request->input('internalCode'));
        $article->setCostPrice($request->input('costPrice'));
        $article->setCurrency($request->input('currency'));

        $this->articleService->update($article);
        Session::flash('message', trans('backend/messages.confirmation.create.article'));

        return redirect()->to('/management/articles/'. $id . '/edit');
    }

    public function getDataTables()
    {
        $articles = $this->articleService->findAll(App::getLocale());
        $articlesCollection = new Collection();

        foreach ($articles as $article) {
            $articlesCollection->push([
                'id' => $article->getId(),
                'name' => $article->getName(),
                'category' => $article->getCategory()->getName(),
                'price' => $article->getPrice(),
                'costPrice' => $article->getCostPrice(),
                'barCode' => $article->getBarCode(),
                'internalCode' => $article->getInternalCode()
            ]);
        }

        return Datatables::of($articlesCollection)->make();
    }
}
