<?php
namespace EventoOriginal\Core\Services;

use DateTime;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Persistence\Repositories\UserRepository;
use Exception;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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
        return $this->userRepository->find($id);
    }
}
