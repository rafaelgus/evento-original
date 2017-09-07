<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use Doctrine\ORM\Query;
use EventoOriginal\Core\Entities\Menu;
use EventoOriginal\Core\Entities\MenuItem;
use Gedmo\Translatable\Query\TreeWalker\TranslationWalker;
use Gedmo\Translatable\TranslatableListener;

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

    public function findByMenu(Menu $menu, string $locale = 'es')
    {
        $qb = $this->createQueryBuilder('menu_item')
            ->select('menu_item')
            ->where('menu_item.menu = :menu_id')
            ->setParameter('menu_id', $menu->getId());

        $query = $qb->getQuery();

        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            TranslationWalker::class
        );
        $query->setHint(
            TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            $locale
        );


        $query->useResultCache(true, 3600, 'menu_items');

        return $query->getResult();
    }
}
