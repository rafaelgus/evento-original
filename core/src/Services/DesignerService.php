<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Designer;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Enums\UserRole;
use EventoOriginal\Core\Persistence\Repositories\DesignerRepository;

class DesignerService
{
    private $designerRepository;
    private $userService;
    /**
     * @var RoleService
     */
    private $roleService;

    /**
     * DesignerService constructor.
     * @param DesignerRepository $designerRepository
     * @param UserService $userService
     * @param RoleService $roleService
     */
    public function __construct(
        DesignerRepository $designerRepository,
        UserService $userService,
        RoleService $roleService
    ) {
        $this->designerRepository = $designerRepository;
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function create(User $user, string $nickname)
    {
        $designer = new Designer();
        $designer->setUser($user);
        $designer->setNickname($nickname);

        $this->designerRepository->save($designer);

        $designerRole = $this->roleService->findByName(UserRole::DESIGNER);

        $this->userService->addRole($user, $designerRole);

        return $designer;
    }
}
