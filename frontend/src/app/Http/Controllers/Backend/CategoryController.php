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
        $this->categoryService->create($request->input('name'));

        Session::flash('message', trans('backend/messages.confirmation.create.category'));

        return redirect()->to(self::CATEGORY_CREATE_ROUTE);
    }

    public function update(UpdateCategoryRequest $request)
    {
        $category = $this->categoryService->findOneById($request->input('idCategory'), App::getLocale());

        $this->categoryService->update($category, $request->input('name'));

        Session::flash('message', trans('backend/messages.confirmation.edit.category'));

        return redirect()->to('/management/category/'. $category->getId() . '/edit');
    }

    public function getDataTables()
    {
        $categories = $this->categoryService->findAll(App::getLocale());
        $allergenCollection = new Collection();

        foreach ($categories as $category) {
            $allergenCollection->push([
                'id' => $category->getId(),
                'name' => $category->getName()
            ]);
        }

        return Datatables::of($allergenCollection)->make(true);
    }
}
