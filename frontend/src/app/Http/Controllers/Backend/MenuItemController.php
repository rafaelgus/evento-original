<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreMenuItemRequest;
use EventoOriginal\Core\Services\MenuItemService;
use EventoOriginal\Core\Services\MenuService;
use Exception;
use Illuminate\Support\Facades\Session;

class MenuItemController extends Controller
{
    const MENU_ITEM_CREATE_ROUTE = '/management/menu-item/create';

    private $menuItemService;
    private $menuService;

    public function __construct(
        MenuItemService $menuItemService,
        MenuService $menuService
    ) {
        $this->menuItemService = $menuItemService;
        $this->menuService = $menuService;
    }

    public function create()
    {
        $menus = $this->menuService->findAll();

        return view('backend.admin.menu_items.create')->withMenus($menus);
    }

    public function store(StoreMenuItemRequest $request)
    {
        try {
            $this->menuItemService->create($request->all());

            Session::flash('message', trans('backend/messages.confirmation.create.menu_item'));
        } catch (Exception $exception) {
            Session::flash('error', trans('backend/messages.error.create'));
            Log::error('Error when try to store menu item: ' . $exception->getMessage());
        }

        return redirect(self::MENU_ITEM_CREATE_ROUTE);
    }

    public function edit()
    {

    }
}
