<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Menu;

class MenuRepository extends BaseRepository
{
    public function save(Menu $menu, bool $flush = true)
    {
        $this->getEntityManager()->persist($menu);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(Menu $menu, bool $flush = true)
    {
        $this->getEntityManager()->remove($menu);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById(int $id)
    {
        return $this->find($id);
    }

    public function findByType(string $type, bool $visible)
    {
        $qb = $this->createQueryBuilder('menu')
            ->select('menu')
            ->where('menu.type = :type')
            ->setParameter('type', $type);

        $query = $qb->getQuery();

        $query->useQueryCache(true);
        $query->useResultCache(true, 3600, 'menus');

        return $query->getOneOrNullResult();
    }
}
