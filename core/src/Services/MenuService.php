<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Menu;
use EventoOriginal\Core\Persistence\Repositories\MenuRepository;

class MenuService
{
    private $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function findByType(string $type)
    {
        return $this->menuRepository->findByType($type);
    }

    public function create()
    {
        $menu = new Menu();

        return $menu;
    }
}
