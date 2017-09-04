<?php

namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Menu;
use EventoOriginal\Core\Entities\MenuItem;
use EventoOriginal\Core\Persistence\Repositories\MenuItemRepository;

class MenuItemService
{
    private $menuItemRepository;

    public function __construct(MenuItemRepository $menuItemRepository)
    {
        $this->menuItemRepository = $menuItemRepository;
    }

    public function findByMenu(Menu $menu, string $locale)
    {
        return $this->menuItemRepository->findByMenu($menu, $locale);
    }

    public function create(array $data)
    {
        $menuItem = new MenuItem();
        $menuItem->setTitle($data['title']);
        $menuItem->setUrl($data['url']);
        $menuItem->setPosition($data['position']);
        $menuItem->setLevel(1);
        $menuItem->setImage('test');
        $menuItem->setVisible(isset($data['visible']));

        foreach ($data['sub_items_titles'] as $i => $title) {
            $subitem = new MenuItem();
            $subitem->setTitle($title);
            $subitem->setUrl($data['sub_items_urls'][$i]);
            $subitem->setLevel(2);
            $subitem->setPosition($i);
            $subitem->setParent($menuItem);
            $subitem->setVisible(isset($data['visible']));

            $menuItem->addSubitem($subitem);
        }

        return $this->menuItemRepository->save($menuItem);
    }
}
