<?php
namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\StoreIngredientRequest;
use EventoOriginal\Core\Services\IngredientService;

class IngredientController
{
    protected $ingredientService;

    public function __construct(IngredientService $ingredientService)
    {
        $this->ingredientService = $ingredientService;
    }

    public function index()
    {
        return view('backend.ingredients.index');
    }

    public function create()
    {
        return view('backend.ingredients.create');
    }

    public function edit(int $id)
    {
        $ingredient = $this->ingredientService->findOneById($id);
        return view('backend.ingredients.edit')->with(['ingredient' => $ingredient]);
    }

    public function store(StoreIngredientRequest $request)
    {

    }
}