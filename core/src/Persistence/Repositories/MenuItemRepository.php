<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\MenuItem;

class MenuItemRepository extends BaseRepository
{
    public function save(MenuItem $menuItem, bool $flush = true)
    {
        $this->getEntityManager()->persist($menuItem);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(MenuItem $menuItem, bool $flush = true)
    {
        $this->getEntityManager()->remove($menuItem);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(int $id)
    {
        return $this->find($id);
    }
}
