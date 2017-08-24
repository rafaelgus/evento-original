<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function create()
    {
        return view('backend.admin.menus.create');
    }
}
