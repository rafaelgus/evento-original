<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Article;
use EventoOriginal\Core\Entities\Design;
use EventoOriginal\Core\Entities\Designer;
use EventoOriginal\Core\Entities\Order;
use EventoOriginal\Core\Entities\OrderDetail;
use Illuminate\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

class DesignRepository extends BaseRepository
{
    use PaginatesFromParams;

    public function save(Design $design, bool $flush = true)
    {
        $this->getEntityManager()->persist($design);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneById(int $id)
    {
        return $this->find($id);
    }

    public function getAllByDesignerPaginated(
        Designer $designer,
        int $currentPage = 1,
        int $maxItems = 10
    ): LengthAwarePaginator {
        $query = $this->createQueryBuilder('d')
            ->where('d.designer = :designer_id')
            ->orderBy('d.createdAt', 'desc')
            ->setParameter('designer_id', $designer->getId())
            ->getQuery();

        return $this->paginate($query, $maxItems, $currentPage);
    }

    public function getAllByDesignerAndStatusPaginated(
        Designer $designer,
        string $status,
        int $currentPage = 1,
        int $maxItems = 10
    ): LengthAwarePaginator {
        $query = $this->createQueryBuilder('d')
            ->where('d.designer = :designer_id')
            ->andWhere('d.status = :status')
            ->orderBy('d.createdAt', 'desc')
            ->setParameter('designer_id', $designer->getId())
            ->setParameter('status', $status)
            ->getQuery();

        return $this->paginate($query, $maxItems, $currentPage);
    }

    public function findAllByStatusPaginated(
        string $status,
        int $currentPage = 1,
        int $maxItems = 10
    ) {
        $query = $this->createQueryBuilder('d')
            ->where('d.status = :status')
            ->setParameter('status', $status)
            ->getQuery();

        return $this->paginate($query, $maxItems, $currentPage);
    }

    public function findInOrder(Order $order)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT d FROM ' . Design::class . ' d JOIN ' . OrderDetail::class .
                ' od WITH  od.order = :order_id JOIN ' . Article::class . ' a WITH a.id = od.article WHERE a.design = d.id')
            ->setParameter('order_id', $order->getId());

        return $query->getResult();
    }
}
