<?php
namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\StoreArticleRequest;
use App\Http\Requests\Backend\UpdateArticleRequest;
use EventoOriginal\Core\Entities\Article;
use EventoOriginal\Core\Services\AllergenService;
use EventoOriginal\Core\Services\ArticleService;
use EventoOriginal\Core\Services\BrandService;
use EventoOriginal\Core\Services\CategoryService;
use EventoOriginal\Core\Services\ColorService;
use EventoOriginal\Core\Services\FlavourService;
use EventoOriginal\Core\Services\HealthyService;
use EventoOriginal\Core\Services\ImageService;
use EventoOriginal\Core\Services\IngredientService;
use EventoOriginal\Core\Services\LicenseService;
use EventoOriginal\Core\Services\PriceService;
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
    protected $brandService;
    protected $priceService;
    protected $healthyService;

    public function __construct(
        ArticleService $articleService,
        CategoryService $categoryService,
        TagService $tagService,
        ColorService $colorService,
        AllergenService $allergenService,
        FlavourService $flavourService,
        ImageService $imageService,
        LicenseService $licenseService,
        IngredientService $ingredientService,
        BrandService $brandService,
        PriceService $priceService,
        HealthyService $healthyService
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
        $this->brandService = $brandService;
        $this->priceService = $priceService;
        $this->healthyService = $healthyService;
    }

    public function index()
    {
        return view('backend.admin.articles.index');
    }

    public function create()
    {
        return view('backend.admin.articles.create')
            ->with([
                'ableToLoad' => false,
                'articleId' => false
            ]);
    }

    public function edit(int $id)
    {
        $article = $this->articleService->findOneById($id, App::getLocale());

        if ($article->getPriceType() == Article::PRICE_TYPE_IN_BULK) {
            $priceType = 2;
        } else {
            $priceType = 1;
        }

        $allergens = $this->allergenService->findAll(App::getLocale());
        $flavours = $this->flavourService->findAll(App::getLocale());
        $colors = $this->colorService->findAll(App::getLocale());
        $tags = $this->tagsService->findAll(App::getLocale());
        $ingredients = $this->ingredientService->findAll(App::getLocale());
        $licenses = $this->licenseService->findAll();
        $categories = $this->categoryService->findAll(App::getLocale());
        $brands = $this->brandService->findAll();
        $healthys = $this->healthyService->findAll(App::getLocale());

        return view('backend.admin.articles.edit')
            ->with([
                'article' => $article,
                'priceType' => $priceType,
                'allergens' => $allergens,
                'flavours' => $flavours,
                'colors' => $colors,
                'tags' => $tags,
                'ingredients' => $ingredients,
                'licenses' => $licenses,
                'categories' => $categories,
                'brands' => $brands,
                'healthys' => $healthys
            ]);
    }

    public function store(StoreArticleRequest $request)
    {
        $allergens = $this
            ->allergenService
            ->findByIds(
                ($request->input('allergens') ?: [])
            );

        $tags = $this
            ->tagsService
            ->findByIds(
                ($request->input('tags') ?: [])
            );

        $colors = $this
            ->colorService
            ->findByIds(
                ($request->input('colors') ?: [])
            );

        $flavours = $this
            ->flavourService
            ->findByIds(
                ($request->input('flavours') ?: [])
            );

        $healthys = $this
            ->healthyService
            ->findByIds(
                ($request->input('healthys') ?: [])
            );

        $category = $this
            ->categoryService
            ->findOneById(
                $request->input('category'),
                App::getLocale()
            );

        $license = null;
        if ($request->input('license')) {
            $license = $this
                ->licenseService
                ->findOneById(
                    $request->input('license')
                );
        }

        $ingredients = $this
            ->ingredientService
            ->findByIds(
                ($request->input('ingredients') ?: [])
            );

        $brand = $this
            ->brandService
            ->findOneById(
                $request->input('brand')
            );

        $priceType = null;
        if ($request->input('priceType') == 1) {
            $priceType = Article::PRICE_TYPE_UNIT;
        } elseif ($request->input('priceType') == 2) {
            $priceType = Article::PRICE_TYPE_IN_BULK;
        }

        $prices = [];

        if ($request->has('quantities') and $request->has('prices')) {
            for ($i = 0; $i < count($request->input('quantities')); $i++) {
                $price = $this
                    ->priceService
                    ->create(17,
                        $request->input('quantities')[$i],
                        $request->input('prices')[$i]
                    );

                $prices[] = $price;
            }
        }

        $data = $request->all();

        $article = $this->articleService->create(
            $data['name'],
            $data['description'],
            $data['shortDescription'],
            $data['barCode'],
            $data['internalCode'],
            $data['status'],
            ($request->input('slug') ?: str_slug($request->input('name'))),
            $data['price'],
            $priceType,
            'EUR',
            null,
            $data['costPrice'],
            $brand,
            $category,
            $license,
            $tags,
            $colors,
            $flavours,
            $allergens,
            $ingredients,
            $prices,
            $healthys
        );

        $this->articleService->save($article);

        foreach ($prices as $price) {
            $price->setArticle($article);
            $this->priceService->save($price);
        }

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
            $imageName = uniqid($file->getFilename()) . '.' . $file->getClientOriginalExtension();

            $filePath = '/images/' . $imageName;

            Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');

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
            $images = $this->storeImage(
                $request->allFiles(),
                $article
            );
        } else {
            $images = [];
        }

        $allergens = $this
            ->allergenService
            ->findByIds(
                ($request->input('allergens') ?: [])
            );

        $tags = $this
            ->tagsService
            ->findByIds(
                ($request->input('tags') ?: [])
            );

        $colors = $this
            ->colorService
            ->findByIds(
                ($request->input('colors') ?: [])
            );

        $flavours = $this
            ->flavourService
            ->findByIds(
                ($request->input('flavours') ?: [])
            );

        $healtyhs = $this
            ->healthyService
            ->findByIds(
                ($request->input('healthys') ?: [])
            );

        $category = $this
            ->categoryService
            ->findOneById(
                $request->input('category'),
                App::getLocale()
            );

        $license = null;
        if ($request->input('license')) {
            $license = $this
                ->licenseService
                ->findOneById(
                    $request->input('license')
                );
        }

        $ingredients = $this
            ->ingredientService
            ->findByIds(
                ($request->input('ingredients') ?: [])
            );

        $brand = $this
            ->brandService
            ->findOneById(
                $request->input('brand')
            );

        $article->setAllergens($allergens);
        $article->setColors($colors);
        $article->setFlavours($flavours);
        $article->setHealthys($healtyhs);
        $article->setTags($tags);
        $article->setCategory($category);
        $article->setName($request->input('name'));
        $article->setSlug($request->input('slug'));
        $article->setShortDescription($request->input('shortDescription'));
        $article->setDescription($request->input('description'));
        $article->setBarCode($request->input('barCode'));
        $article->setInternalCode($request->input('internalCode'));
        $article->setLicense($license);
        $article->setBrand($brand);
        $article->setIngredients($ingredients);
        $article->setStatus($request->input('status'));

        $priceType = null;
        if ($request->input('priceType') == 1) {
            $priceType = Article::PRICE_TYPE_UNIT;
            $article->setPrice($request->input('price'));
        } elseif ($request->input('priceType') == 2) {
            $priceType = Article::PRICE_TYPE_IN_BULK;
        }
        $article->setPriceType($priceType);

        $prices = [];

        if ($request->has('quantities') and $request->has('prices')) {
            for ($i = 0; $i < count($request->input('quantities')); $i++) {
                $price = $this
                    ->priceService
                    ->create(17,
                        $request->input('quantities')[$i],
                        $request->input('prices')[$i]
                    );

                $article->addPricePerQuantity($price);
            }
        }

        $article->setCostPrice($request->input('costPrice'));
        $article->setPriceCurrency('EUR');

        $this->articleService->update($article);
        Session::flash('message', trans('backend/messages.confirmation.create.article'));

        return redirect()->to('/management/articles/' . $id . '/edit');
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
        $article = $this
            ->articleService
            ->findOneById(
                $request->input('articleId'),
                App::getLocale()
            );

        $this->storeImage($request->allFiles(), $article);
        $response = ['success' => true];

        return json_encode($response);
    }

    public function getImages(int $articleId)
    {
        $article = $this->articleService->findOneById($articleId, App::getLocale());
        $images = $article->getImages();

        $files = [];

        foreach ($images as $image) {
            $file = Storage::disk('s3')->get('/images/' . $image->getPath());
            $files[] = $file;
        }
        return $files;
    }

    public function getImage(string $filename)
    {
        $image = Storage::disk('s3')->get('/images/' . $filename);

        return $image;
    }

    public function deleteImage(int $imageId)
    {
        $image = $this->imageService->findById($imageId);

        if (Storage::disk('s3')->exists('/images/' . $image->getPath())) {
            Storage::disk('s3')->delete('/images/' . $image->getPath());

            $this->imageService->delete($image);
        } else {
            return ['status' => false];
        }
        return ['status' => true];
    }

    public function getPrices(int $articleId)
    {
        $article = $this->articleService->findOneById($articleId, App::getLocale());

        $prices = $this->priceService->findByArticle($article);

        $parsedPrices = [];

        foreach ($prices as $price) {
            $parsedPrices[] = [
                'id' => $price->getId(),
                'quantity' => $price->getGramme(),
                'price' => $price->getPrice()
            ];
        }

        return $parsedPrices;
    }

    public function updatePrice(Request $request)
    {
        $price = $this->priceService->findById($request->input('id'));

        $price->setPrice($request->input('price'));
        $price->setGramme($request->input('quantity'));

        $this->priceService->save($price);

        return ['message' => 'el precio se actualizo correctamente'];
    }
}
