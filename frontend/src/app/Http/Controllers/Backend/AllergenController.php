<?php
namespace App\Http\Controllers\Backend;

use EventoOriginal\Core\Services\AllergenService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Validator;
use Yajra\Datatables\Facades\Datatables;

class AllergenController
{
    const ALLERGEN_CREATE_ROUTE = '/management/allergen/create';

    protected $allergenService;

    public function __construct(AllergenService $allergenService)
    {
        $this->allergenService = $allergenService;
    }

    public function index()
    {
        return view('backend.admin.allergen.index');
    }

    public function create()
    {
        return view('backend.admin.allergen.create');
    }

    public function store(Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/management/allergen/create')
                    ->withErrors($validator)
                    ->withInput();
        }

        $this->allergenService->create($request->input('name'));

        Session::flash('message', trans('backend/messages.confirmation.create.allergen'));
        return redirect(self::ALLERGEN_CREATE_ROUTE);
    }

    public function getDataTables()
    {
        $allergens = $this->allergenService->findAll('es');
        $allergenCollection = new Collection();

        foreach ($allergens as $allergen) {
            $allergenCollection->push([
               'id' => $allergen->getId(),
                'name' => $allergen->getName()
            ]);
        }

        return Datatables::of($allergenCollection)->make(true);
    }
}
