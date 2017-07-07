<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Ingredient;
use EventoOriginal\Core\Persistence\Repositories\IngredientRepository;

class IngredientService
{
    protected $ingredientRepository;

    public function __construct(IngredientRepository $ingredientRepository)
    {
        $this->ingredientRepository = $ingredientRepository;
    }

    /**
     * @param string $name
     * @return Ingredient
     */
    public function create(string $name)
    {
        $ingredient = new Ingredient();
        $ingredient->setName($name);

        $this->ingredientRepository->save($ingredient, true);

        return $ingredient;
    }

    /**
     * @param Ingredient $ingredient
     * @param string $name
     */
    public function update(Ingredient $ingredient, string $name)
    {
        $ingredient->setName($name);

        $this->ingredientRepository->save($ingredient, true);
    }

    /**
     * @param int $id
     * @return null|Ingredient
     */
    public function findOneById(int $id)
    {
        $ingredient = $this->ingredientRepository->find($id);

        return $ingredient;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->ingredientRepository->findAll();
    }
}