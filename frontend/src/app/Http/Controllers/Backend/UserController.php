<?php
namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\StoreUserRequest;
use App\Http\Requests\Backend\UpdateUserRequest;
use EventoOriginal\Core\Services\RoleService;
use EventoOriginal\Core\Services\UserService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Datatables;

class UserController
{
    const CREATE_USER_URL = '/management/users/create';

    protected $userService;
    protected $roleService;

    public function __construct(
        UserService $userService,
        RoleService $roleService
    ) {
        $this->userService = $userService;
        $this->roleService = $roleService;
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
        $user = $this->userService->findById($id);

        return view('backend.admin.users.edit')->with(['user' => $user]);
    }

    public function store(StoreUserRequest $request)
    {
        $rolesIds = $request->input('roles');

        $roles = [];

        foreach ($rolesIds as $roleId) {
            $role = $this->roleService->findById($roleId);
            $roles[] = $role;
        }

        $data = $request->all();

        $user = $this->userService->create(
            $data['name'],
            $data['email'],
            $data['password'],
            $roles
        );

        Session::flash('message', trans('backend/messages.confirmation.create.users'));
        return redirect()->to(self::CREATE_USER_URL);
    }

    public function update(int $id, UpdateUserRequest $request)
    {
        $user = $this->userService->findById($id);

        $user->setPassword($request->input('password'));
        $user->setName($request->input('name'));
        $user->setEmail($request->input('email'));
        $rolesIds = $request->input('roles');

        $roles = [];

        foreach ($rolesIds as $roleId) {
            $role = $this->roleService->findById($roleId);
            $roles[] = $role;
        }

        $user->setRoles($roles);

        $this->userService->update($user);
        Session::flash('message', trans('backend/messages.confirmation.edit.users'));

        return redirect()->to('/management/users/'. $user->getId() .'/edit');
    }

    public function getDataTables()
    {
        $users = $this->userService->findAll();
        $userCollection = new Collection();

        foreach ($users as $user) {
            $userCollection->push([
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            ]);
        }

        return Datatables::of($userCollection)->make(true);
    }

    public function getRoles()
    {
        $roles = $this->roleService->findAll();

        $parsedRoles = [];

        foreach($roles as $role) {
            $parsedRoles[] = ['id' => $role->getId(), 'name' => $role->getName()];
        }

        return ['roles' => $parsedRoles];
    }
}