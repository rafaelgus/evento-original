<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Payout;
use EventoOriginal\Core\Entities\User;
use Illuminate\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

class PayoutRepository extends BaseRepository
{
    use PaginatesFromParams;

    public function save(Payout $payout, bool $flush = true)
    {
        $this->getEntityManager()->persist($payout);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByExternalId(string $externalId)
    {
        return $this->findOneBy(['externalId' => $externalId]);
    }

    public function findByUser(User $user)
    {
        return $this->findBy(['user' => $user], ['date' => 'DESC']);
    }

    public function findAllByUserPaginated(User $user, int $currentPage = 1, int $maxItems = 10): LengthAwarePaginator
    {
        $query = $this->createQueryBuilder('p')
            ->where('p.user = :user')
            ->orderBy('p.date', 'desc')
            ->setParameter('user', $user->getId())
            ->getQuery();

        return $this->paginate($query, $maxItems, $currentPage);
    }
}
