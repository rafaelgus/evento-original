<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreColorRequest;
use App\Http\Requests\Backend\UpdateColorRequest;
use EventoOriginal\Core\Services\ColorService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

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
        $this->colorService->create($request->input('name'), $request->input('hexadecimalCode'));

        Session::flash('message', trans('backend/messages.confirmation.create.color'));

        return redirect()->to(self::COLOR_CREATE_ROUTE);
    }

    public function edit(int $id)
    {
        $color = $this->colorService->findOneById($id, 'es');

        return view('backend.admin.colors.edit')->withColor($color);
    }

    public function update(UpdateColorRequest $request, int $id)
    {
        $color = $this->colorService->findOneById($id, 'es');

        $this->colorService->update($color, $request->input('name'), $request->input('hexadecimalCode'));

        Session::flash('message', trans('backend/messages.confirmation.create.color'));

        return redirect()->to(self::COLOR_ROUTE);
    }

    public function getDatatable()
    {
        $colors = $this->colorService->findAll('es');
        $colorsCollection = new Collection();

        foreach ($colors as $color) {
            $colorsCollection->push([
                'id' => $color->getId(),
                'name' => $color->getName(),
                'hexadecimalCode' => $color->getHexadecimalCode()
            ]);
        }

        return Datatables::of($colorsCollection)->make(true);
    }

    public function getAllColors()
    {
        $colors = $this->colorService->findAll('es');
        $parsedColors = [];

        foreach ($colors as $color) {
            $parsedColors[] = ['id' => $color->getId(), 'name' => $color->getName()];
        }

        return $parsedColors;
    }
}
