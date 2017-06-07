<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreColorRequest;
use EventoOriginal\Core\Services\ColorService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;

class ColorController extends Controller
{
    private $colorService;

    const COLOR_ROUTE = '/management/color';
    const COLOR_CREATE_ROUTE = '/management/color/create';

    public function __construct(ColorService $colorService)
    {
        $this->colorService = $colorService;
    }

    public function index()
    {
        return view('backend.admin.colors.index');
    }

    public function create()
    {
        return view('backend.admin.colors.create');
    }

    public function store(StoreColorRequest $request)
    {
        $this->colorService->create($request->input('name'));

        Session::flash('message', trans('backend/messages.confirmation.create.color'));

        return redirect()->to(self::COLOR_CREATE_ROUTE);
    }

    public function getDatatable()
    {
        $colors = $this->colorService->findAll('es');
        $colorsCollection = new Collection();

        foreach ($colors as $category) {
            $colorsCollection->push([
                'id' => $category->getId(),
                'name' => $category->getName()
            ]);
        }

        return Datatables::of($colorsCollection)->make(true);
    }
}