<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\User;

class UserRepository extends BaseRepository
{
    public function findById(int $id)
    {
        return $this->find($id);
    }

    public function save(User $user)
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function existEmail(string $email)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $result = $qb->select('u')
            ->from('User', 'u')
            ->where('u.email=' . $email);

        $user = $result->getFirstResult();

        return $user ? true : false;
    }
}
