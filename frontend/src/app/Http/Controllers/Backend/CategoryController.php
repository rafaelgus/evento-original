<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreCategoryRequest;
use EventoOriginal\Core\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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

    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->create($request->input('name'));

        Session::flash('message', trans('backend/messages.confirmation.create.category'));

        return redirect()->to(self::CATEGORY_CREATE_ROUTE);
    }
}
