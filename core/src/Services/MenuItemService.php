<?php

namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Menu;
use EventoOriginal\Core\Entities\MenuItem;
use EventoOriginal\Core\Persistence\Repositories\MenuItemRepository;

class MenuItemService
{
    private $menuItemRepository;
    private $menuService;

    public function __construct(
        MenuItemRepository $menuItemRepository,
        MenuService $menuService
    ) {
        $this->menuItemRepository = $menuItemRepository;
        $this->menuService = $menuService;
    }

    public function findByMenu(Menu $menu, string $locale)
    {
        return $this->menuItemRepository->findByMenu($menu, $locale);
    }

    public function findById(int $id)
    {
        return $this->menuItemRepository->findById($id);
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

        $menu = $this->menuService->findById($data['menu_id']);
        $menuItem->setMenu($menu);

        return $this->menuItemRepository->save($menuItem);
    }

    public function createSubitem(array $data)
    {
        $menuItem = new MenuItem();
        $menuItem->setTitle($data['title']);
        $menuItem->setUrl($data['url']);
        $menuItem->setPosition($data['position']);
        $menuItem->setLevel(1);
        $menuItem->setImage($data['imageUrl']);
        $menuItem->setVisible(isset($data['visible']));

        $parent = $this->findById($data['menu_item_id']);
        $menuItem->setParent($parent);

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

    public function updateSubitem(MenuItem $menuItem, array $data)
    {
        $menuItem->setTitle($data['title']);
        $menuItem->setUrl($data['url']);
        $menuItem->setPosition($data['position']);
        $menuItem->setLevel(1);

        if (isset($data['imageUrl'])) {
            $menuItem->setImage($data['imageUrl']);
        }

        $menuItem->setVisible(isset($data['visible']));

        foreach ($menuItem->getSubitems() as $s) {
            $this->remove($s);
        }

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

    public function remove(MenuItem $menuItem)
    {
        return $this->menuItemRepository->delete($menuItem);
    }
}
