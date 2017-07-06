<?php
namespace EventoOriginal\Core\Persistence\Repositories;


use EventoOriginal\Core\Entities\Ingredient;

class IngredientRepository extends BaseRepository
{
    public function save(Ingredient $ingredient, bool $flush = true)
    {
        $this->getEntityManager()->persist($ingredient);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(Ingredient $ingredient, bool $flush = true)
    {
        $this->getEntityManager()->remove($ingredient);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(int $id)
    {
        return $this->find($id);
    }
}