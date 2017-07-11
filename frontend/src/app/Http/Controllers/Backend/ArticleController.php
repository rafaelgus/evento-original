<?php
namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\StoreArticleRequest;
use App\Http\Requests\Backend\UpdateArticleRequest;
use App\Http\Requests\Backend\UpdateCategoryRequest;
use EventoOriginal\Core\Entities\License;
use EventoOriginal\Core\Services\AllergenService;
use EventoOriginal\Core\Services\ArticleService;
use EventoOriginal\Core\Services\CategoryService;
use EventoOriginal\Core\Services\ColorService;
use EventoOriginal\Core\Services\FlavourService;
use EventoOriginal\Core\Services\ImageService;
use EventoOriginal\Core\Services\IngredientService;
use EventoOriginal\Core\Services\LicenseService;
use EventoOriginal\Core\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
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
    protected $imageService;
    protected $licenseService;
    protected $ingredientService;

    public function __construct(
        ArticleService $articleService,
        CategoryService $categoryService,
        TagService $tagService,
        ColorService $colorService,
        AllergenService $allergenService,
        FlavourService $flavourService,
        ImageService $imageService,
        LicenseService $licenseService,
        IngredientService $ingredientService
    ) {
        $this->articleService = $articleService;
        $this->categoryService = $categoryService;
        $this->tagsService = $tagService;
        $this->flavourService = $flavourService;
        $this->colorService = $colorService;
        $this->allergenService = $allergenService;
        $this->imageService = $imageService;
        $this->licenseService = $licenseService;
        $this->ingredientService = $ingredientService;
    }

    public function index()
    {
        return view('backend.admin.articles.index');
    }

    public function create()
    {
        return view('backend.admin.articles.create')
            ->with(['ableToLoad' => false,
                    'articleId' => false
                ]);
    }

    public function edit(int $id)
    {
        $article = $this->articleService->findOneById($id, App::getLocale());

        return view('backend.admin.articles.edit')->with('article', $article);
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
                $request->input('colors')
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

        $license = $this
            ->licenseService
            ->findOneById(
                $request->input('license')
            );

        $ingredients = $this
            ->ingredientService
            ->findByIds(
                $request->input('ingredients')
            );

        $data = $request->all();
        $article = $this->articleService->create(
            $data['name'],
            $data['description'],
            $data['barCode'],
            $data['internalCode'],
            $data['status'],
            $data['slug'],
            $data['price'],
            'EUR',
            null,
            $data['costPrice'],
            $data['ingredients'],
            $category,
            $license,
            $tags,
            $colors,
            $flavours,
            $allergens,
            $ingredients
        );

        $this->articleService->save($article);

        Session::flash('message', trans('backend/messages.confirmation.create.article'));

        return view('backend.admin.articles.create')
            ->with([
                'ableToLoad' => true,
                'articleId' => $article->getId()
                ]);
    }

    public function storeImage(array $files, $article)
    {
        $imageNumber = 1;
        $images = [];

        foreach ($files as $file) {
            $imageName = bcrypt($file->getFilename());
            $file->storeAs('/article', $imageName .'.jpg');
            $image = $this
                ->imageService
                ->create(
                    $imageName,
                    'image_' . $imageNumber, $article);

            $images[] = $image;
            $imageNumber = $imageNumber + 1;
        }

        return $images;
    }

    public function update(int $id, UpdateArticleRequest $request)
    {
        $article = $this->articleService->findOneById($id, App::getLocale());

        if ($request->allFiles()) {
            $images = $this->storeImage($request->allFiles(), $article  );
        } else {
            $images = [];
        }

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
                $request->input('colors')
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

        $article->setAllergens($allergens);
        $article->setColors($colors);
        $article->setFlavours($flavours);
        $article->setTags($tags);
        $article->setCategory($category);
        $article->setName($request->input('name'));
        $article->setDescription($request->input('description'));
        $article->setBarCode($request->input('barCode'));
        $article->setPrice($request->input('internalCode'));
        $article->setCostPrice($request->input('costPrice'));
        $article->setPriceCurrency('EUR');

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
        return Datatables::of($articlesCollection)->make(true);
    }

    public function uploadImages(Request $request)
    {
        $response = ['success' => true];

        return json_encode($response);
    }
}
