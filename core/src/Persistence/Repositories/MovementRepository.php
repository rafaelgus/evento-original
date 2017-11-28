<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Movement;
use EventoOriginal\Core\Entities\User;
use Illuminate\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

class MovementRepository extends BaseRepository
{
    use PaginatesFromParams;

    public function save(Movement $movement, bool $flush = true)
    {
        $this->getEntityManager()->persist($movement);

        if ($flush) {
            $this->getEntityManager()->flush();
        }

        return $movement;
    }

    public function findAllByUserPaginated(User $user, int $currentPage = 1, int $maxItems = 10): LengthAwarePaginator
    {
        $query = $this->createQueryBuilder('movement')
            ->join('movement.wallet', 'wallet', 'WITH', 'wallet.id = movement.wallet')
            ->where('wallet.user = :user_id')
            ->orderBy('movement.date', 'desc')
            ->setParameter('user_id', $user->getId())
            ->getQuery();

        return $this->paginate($query, $maxItems, $currentPage);
    }
}
