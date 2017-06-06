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

    public function create(string $name, string $email, string $password)
    {
        $user = new User();

        if (!$this->userRepository->existEmail($email)) {
            $user->setName($name);
            $user->setEmail($email);
            $user->setPassword(bcrypt($password));
            $this->userRepository->save($user);
        } else {
            throw new Exception('This email already exist');
        }

        return $user;
    }

    public function update(User $user)
    {
        $this->userRepository->save($user);
    }
    public function findAll()
    {
        return $this->userRepository->findAll();
    }
    public function findById(int $id)
    {
        return $this->userRepository->find($id);
    }
}
