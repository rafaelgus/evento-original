<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use DateTime;
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

    public function findLastMovementsByUser(User $user, int $days = 30)
    {
        $today = new DateTime();
        $dateLimit = new DateTime($today->format('Y-m-d'));
        $dateLimit->modify("-" . $days . " days");

        $query = $this->createQueryBuilder('movement')
            ->join('movement.wallet', 'wallet', 'WITH', 'wallet.id = movement.wallet')
            ->where('wallet.user = :user_id')
            ->andWhere('movement.date >= :date_limit')
            ->orderBy('movement.date', 'desc')
            ->setParameters([
                'user_id' => $user->getId(),
                'date_limit' => $dateLimit->format('Y-m-d H:i:s')
            ]);

        return $query->getQuery()->getResult();
    }
}
