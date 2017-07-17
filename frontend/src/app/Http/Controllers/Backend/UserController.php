<?php
/**
 * Created by PhpStorm.
 * User: martinchos
 * Date: 17/07/17
 * Time: 19:18
 */

namespace App\Http\Controllers\Backend;


use EventoOriginal\Core\Services\UserService;

class UserController
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('backend.admin.users.index');
    }

    public function create()
    {
        return view('backend.admin.users.create');
    }

    public function edit(int $id)
    {
        return view('backend.admin.users.edit');
    }

    public function store()
    {

    }
}