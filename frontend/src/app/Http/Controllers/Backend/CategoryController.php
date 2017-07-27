<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreCategoryRequest;
use App\Http\Requests\Backend\UpdateCategoryRequest;
use EventoOriginal\Core\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;

class CategoryController extends Controller
{
    private $categoryService;

    const CATEGORY_ROUTE = '/management/category';
    const CATEGORY_CREATE_ROUTE = '/management/category/create';

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return view('backend.admin.categories.index');
    }

    public function create()
    {
        return view('backend.admin.categories.create');
    }

    public function edit(int $id)
    {
        $category = $this->categoryService->findOneById($id, App::getLocale());

        if (!$category) {
            throw new \Exception('La categoria no existe');
        }

        return view('backend.admin.categories.edit', ['category' => $category]);
    }

    public function store(StoreCategoryRequest $request)
    {
        $name = $request->input('name');
        $slug = ($request->input('slug') ?: str_slug($name));

        $this->categoryService->create($name, $slug, $request->input('description'));

        Session::flash('message', trans('backend/messages.confirmation.create.category'));

        return redirect()->to(self::CATEGORY_CREATE_ROUTE);
    }

    public function update(UpdateCategoryRequest $request, int $id)
    {
        $category = $this->categoryService->findOneById($id, App::getLocale());
        $name = $request->input('name');
        $slug = ($request->input('slug') ?: str_slug($name));
        $this->categoryService->update($category, $name, $slug, $request->input('description'));

        Session::flash('message', trans('backend/messages.confirmation.edit.category'));

        return redirect()->to('/management/category/' . $category->getId() . '/edit');
    }

    public function getDataTables()
    {
        $categories = $this->categoryService->findAll(App::getLocale());
        $allergenCollection = new Collection();

        foreach ($categories as $category) {
            $allergenCollection->push([
                'id' => $category->getId(),
                'name' => $category->getName(),
            ]);
        }

        return Datatables::of($allergenCollection)->make(true);
    }

    public function createSubCategory(int $parentId)
    {
        $category = $this->categoryService->findOneById($parentId, App::getLocale());

        if (!$category) {
            throw new \Exception('la categoria no existe');
        }

        return view('backend.admin.categories.createSubcategory', ['category' => $category]);
    }

    public function subcategories(int $parentId)
    {
        $category = $this->categoryService->findOneById($parentId, App::getLocale());
        return view('backend.admin.categories.subcategories', ['category' => $category]);
    }

    public function getSubCategories(int $parentId)
    {
        $category = $this->categoryService->findOneById($parentId, App::getLocale());
        $subCategories = $this->categoryService->getChildren($category);

        $allergenCollection = new Collection();

        foreach ($subCategories as $subCategory) {
            $allergenCollection->push([
                'id' => $subCategory->getId(),
                'name' => $subCategory->getName()
            ]);
        }

        return Datatables::of($allergenCollection)->make(true);
    }

    public function storeSubcategory(int $parentId, StoreCategoryRequest $request)
    {
        $category = $this
            ->categoryService
            ->findOneById(
                $parentId,
                App::getLocale()
            );

        if ($category->getLevel() == 4) {
            throw new \Exception('No se pueden agregar mas niveles');
        }

        $name = $request->input('name');
        $slug = ($request->input('slug') ?: str_slug($name));

        $this->categoryService->createChildren(
            $category,
            $name,
            $slug,
            $request->input('description')
        );

        Session::flash('message', trans('backend/messages.confirmation.edit.category'));

        return redirect()->to('/management/category/' . $category->getId() . '/createSubCategory');
    }

    public function getAllCategories()
    {
        $categories = $this->categoryService->findAll(App::getLocale());
        $parsedCategories = [];

        foreach ($categories as $category) {
            $parsedCategories[] = ['id' => $category->getId(), 'name' => $category->getName()];
        }

        return $parsedCategories;
    }

}
