<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use EventoOriginal\Core\Services\MenuService;

class MenuController extends Controller
{
    private $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index()
    {
        $menus = $this->menuService->findAll();

        return view('backend.admin.menus.index')->withMenus($menus);
    }

    public function show(int $id)
    {
        $menu = $this->menuService->findById($id);

        return view('backend.admin.menus.show')->withMenu($menu);
    }
}
