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

    public function findAll()
    {
        return $this->menuRepository->findAll();
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

    public function findById(int $id)
    {
        return $this->menuRepository->find($id);
    }
}
