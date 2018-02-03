<?php
namespace EventoOriginal\Core\Services;

use App\Events\UserRegistered;
use DateTime;
use EventoOriginal\Core\Entities\Role;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Persistence\Repositories\UserRepository;
use Exception;

class UserService
{
    private $userRepository;
    private $walletService;
    private $roleService;

    public function __construct(
        UserRepository $userRepository,
        WalletService $walletService,
        RoleService $roleService
    ) {
        $this->userRepository = $userRepository;
        $this->walletService = $walletService;
        $this->roleService = $roleService;
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param array $roles
     * @return User
     * @throws Exception
     */
    public function create(string $name, string $email, string $password, array $roles)
    {
        $user = new User();

        if (!$this->userRepository->existEmail($email)) {
            $user->setName($name);
            $user->setEmail($email);
            $user->setPassword(bcrypt($password));
            $user->setRoles($roles);
            $this->userRepository->save($user);

            $this->walletService->create($user);

            event(new UserRegistered($user));
        } else {
            throw new Exception('This email already exist');
        }

        return $user;
    }

    /**
     * @param User $user
     */
    public function update(User $user)
    {
        $this->userRepository->save($user);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->userRepository->findAll();
    }

    /**
     * @param int $id
     * @return null|User
     */
    public function findById(int $id)
    {
        return $this->userRepository->findById($id);
    }

    public function addRole(User $user, Role $role)
    {
        $user->addRole($role);

        $this->userRepository->save($user);
    }

    public function remove(User $user)
    {
        return $this->userRepository->remove($user);
    }
}
