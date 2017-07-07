<?php
namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\StoreIngredientRequest;
use App\Http\Requests\Backend\UpdateIngredientRequest;
use EventoOriginal\Core\Services\IngredientService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;

class IngredientController
{
    const INGREDIENT_CREATE_ROUTE = '/management/ingredient/create';

    protected $ingredientService;

    public function __construct(IngredientService $ingredientService)
    {
        $this->ingredientService = $ingredientService;
    }

    public function index()
    {
        return view('backend.admin.ingredients.index');
    }

    public function create()
    {
        return view('backend.admin.ingredients.create');
    }

    public function edit(int $id)
    {
        $ingredient = $this->ingredientService->findOneById($id);
        return view('backend.admin.ingredients.edit')->with(['ingredient' => $ingredient]);
    }

    public function store(StoreIngredientRequest $request)
    {
        $this->ingredientService->create($request->input('name'));

        Session::flash('message', trans('backend/messages.confirmation.create.ingredient'));

        return redirect()->to(self::INGREDIENT_CREATE_ROUTE);
    }

    public function update(int $id, UpdateIngredientRequest $request)
    {
        $ingredient = $this->ingredientService->findOneById($id);

        $this->ingredientService->update($ingredient, $request->input('name'));

        Session::flash('message', trans('backend/messages.confirmation.edit.ingredient'));

        return redirect()->to('/management/ingredient/' . $ingredient->getId() . '/edit');
    }

    public function getDataTables()
    {
        $ingredients = $this->ingredientService->findAll('es');
        $ingredientsCollection = new Collection();

        foreach ($ingredients as $ingredient) {
            $ingredientsCollection->push([
                'id' => $ingredient->getId(),
                'name' => $ingredient->getName()
            ]);
        }

        return Datatables::of($ingredientsCollection)->make(true);
    }
}