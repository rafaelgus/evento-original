<?php
namespace App\Http\Controllers\Backend;

use EventoOriginal\Core\Services\AllergenService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Validator;
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
        return view('backend.admin.allergen.create', ['allergen' => null]);
    }

    public function edit(int $id)
    {
        $allergen = $this->allergenService->findOneById($id, App::getLocale());
        return view('backend.admin.allergen.create')->with('allergen', $allergen);
    }

    public function store(Request $request)
    {
        $allergen = null;

        $validator =  Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($request->has('allergenId')) {
            $allergen = $this->allergenService->findOneById($request->input('allergenId'), App::getLocale());
            if ($validator->fails()) {
                return redirect('/management/allergen/'. $allergen->getId() .'/edit')
                    ->withErrors($validator)
                    ->withInput();
            }

            $this->allergenService->update($allergen, $request->input('name'));
            Session::flash('message', trans('backend/messages.confirmation.edit.allergen'));

            return redirect('/management/allergen/'. $allergen->getId() .'/edit');
        } else {
            if ($validator->fails()) {
                return redirect(self::ALLERGEN_CREATE_ROUTE)
                    ->withErrors($validator)
                    ->withInput();
            }
            $this->allergenService->create($request->input('name'));
        }

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
