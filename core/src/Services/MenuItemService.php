<?php

namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Menu;
use EventoOriginal\Core\Entities\MenuItem;
use EventoOriginal\Core\Persistence\Repositories\MenuItemRepository;

class MenuItemService
{
    private $menuItemRepository;
    private $menuService;
    private $categoryService;

    public function __construct(
        MenuItemRepository $menuItemRepository,
        MenuService $menuService,
        CategoryService $categoryService
    ) {
        $this->menuItemRepository = $menuItemRepository;
        $this->menuService = $menuService;
        $this->categoryService = $categoryService;
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
        $menuItem->setPosition($data['position']);
        $menuItem->setLevel(1);
        $menuItem->setVisible(isset($data['visible']));

        $menu = $this->menuService->findById($data['menu_id']);
        $menuItem->setMenu($menu);

        if (array_get($data, 'category_id')) {
            $category = $this->categoryService->findOneById($data['category_id']);

            $menuItem->setCategory($category);
        } else {
            $menuItem->setUrl(array_get($data, 'url'));
        }

        return $this->menuItemRepository->save($menuItem);
    }

    public function update(MenuItem $menuItem, array $data)
    {
        $menuItem->setTitle($data['title']);
        $menuItem->setPosition($data['position']);
        $menuItem->setVisible(isset($data['visible']));

        $menu = $this->menuService->findById($data['menu_id']);
        $menuItem->setMenu($menu);

        if (array_get($data, 'category_id')) {
            $category = $this->categoryService->findOneById($data['category_id']);

            $menuItem->setCategory($category);
        } else {
            $menuItem->setUrl(array_get($data, 'url'));
        }

        return $this->menuItemRepository->save($menuItem);
    }

    public function createSubitem(array $data)
    {
        $menuItem = new MenuItem();
        $menuItem->setTitle($data['title']);

        if (array_key_exists('category_id', $data)) {
            $category = $this->categoryService->findOneById($data['category_id']);

            $menuItem->setCategory($category);
        } else {
            $menuItem->setUrl(array_get($data, 'url'));
        }

        $menuItem->setPosition($data['position']);
        $menuItem->setLevel(1);
        if (isset($data['imageUrl'])) {
            $menuItem->setImage($data['imageUrl']);
        }
        $menuItem->setVisible(isset($data['visible']));

        $parent = $this->findById($data['menu_item_id']);
        $menuItem->setParent($parent);

        foreach ($data['sub_items_titles'] as $i => $title) {
            $subitem = new MenuItem();
            $subitem->setTitle($title);

            $subitemCategoryId = $data['sub_items_categories'][$i];
            $subitemCategory = $this->categoryService->findOneById($subitemCategoryId);
            if ($subitemCategory) {
                $subitem->setCategory($subitemCategory);
            } else {
                $subitem->setUrl($data['sub_items_urls'][$i]);
            }

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
        $menuItem->setPosition($data['position']);
        $menuItem->setLevel(1);

        if (array_key_exists('category_id', $data)) {
            $category = $this->categoryService->findOneById($data['category_id']);

            $menuItem->setCategory($category);
        } else {
            $menuItem->setUrl($data['url']);
        }

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

            $subitemCategoryId = $data['sub_items_categories'][$i];
            $subitemCategory = null;

            if ($subitemCategoryId) {
                $subitemCategory = $this->categoryService->findOneById($subitemCategoryId);
                $subitem->setCategory($subitemCategory);
            }

            $subitem->setCategory($subitemCategory);
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
