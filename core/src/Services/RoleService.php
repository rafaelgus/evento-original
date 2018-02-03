<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Role;
use EventoOriginal\Core\Persistence\Repositories\RoleRepository;

class RoleService
{
    private $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param int $role
     * @return null|Role
     */
    public function findById(int $role)
    {
        return $this->roleRepository->find($role);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->roleRepository->findAll();
    }

    public function findByName(string $name)
    {
        return $this->roleRepository->findOneByName($name);
    }
}
