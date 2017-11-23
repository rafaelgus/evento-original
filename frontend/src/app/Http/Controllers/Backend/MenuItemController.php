<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreMenuItemRequest;
use EventoOriginal\Core\Services\MenuItemService;
use EventoOriginal\Core\Services\MenuService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

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

    public function createSubitem(int $id)
    {
        $menuSelected = $this->menuItemService->findById($id);

        return view('backend.admin.menu_items.sub_items.create')->withMenuSelected($menuSelected);
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

        return redirect()->back();
    }

    public function storeSubitem(StoreMenuItemRequest $request)
    {
        try {
            $data = $request->all();
            if ($request->hasFile('image')) {
                $data['imageUrl'] = $this->storeImage($request->file('image'));
            }

            $this->menuItemService->createSubitem($data);

            Session::flash('message', trans('backend/messages.confirmation.create.menu_item'));
        } catch (Exception $exception) {
            Session::flash('error', trans('backend/messages.error.create'));
            Log::error('Error when try to store menu item: ' . $exception->getMessage());
        }

        return redirect()->back();
    }

    public function storeImage($file)
    {
        $imageName = uniqid($file->getFilename()) . '.' . $file->getClientOriginalExtension();
        $filePath = '/menu-images/' . $imageName;

        Storage::disk('s3')->put($filePath, file_get_contents($file), 'public');

        return $imageName;
    }

    public function editSubitem(int $id)
    {
        $subitem = $this->menuItemService->findById($id);

        return view('backend.admin.menu_items.sub_items.edit')->withSubitem($subitem);
    }

    public function show(int $id)
    {
        $menuItem = $this->menuItemService->findById($id);

        return view('backend.admin.menu_items.show')->withMenuItem($menuItem);
    }

    public function updateSubitem(Request $request, int $id)
    {
        try {
            $data = $request->all();

            if ($request->hasFile('image')) {
                $data['imageUrl'] = $this->storeImage($request->file('image'));
            }

            $menuItem = $this->menuItemService->findById($id);

            $this->menuItemService->updateSubitem($menuItem, $data);

            Session::flash('message', trans('backend/messages.confirmation.create.menu_item'));
        } catch (Exception $exception) {
            Session::flash('error', trans('backend/messages.error.create'));
            Log::error('Error when try to store menu item: ' . $exception->getMessage());
        }

        return redirect()->back();
    }

    public function remove(int $id)
    {
        try {
            $menuItem = $this->menuItemService->findById($id);

            $this->menuItemService->remove($menuItem);

            Session::flash('message', 'Eliminado con exito');
        } catch (Exception $exception) {
            Session::flash('error', 'Error al eliminar');
            Log::error('Error when try to store menu item: ' . $exception->getMessage());
        }

        return redirect()->back();
    }
}
