<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use EventoOriginal\Core\Entities\Order;
use EventoOriginal\Core\Entities\OrderDetail;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Entities\VisitorEvent;
use EventoOriginal\Core\Entities\VisitorLanding;
use EventoOriginal\Core\Enums\VisitorEventType;

class VisitorEventRepository extends BaseRepository
{
    public function findById(int $id)
    {
        return $this->find($id);
    }

    public function save(VisitorEvent $visitorEvent, bool $flush = true)
    {
        $this->getEntityManager()->persist($visitorEvent);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function assignEvents(VisitorLanding $oldVisitorLanding, VisitorLanding $newVisitorLanding)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $q = $qb->update(VisitorEvent::class, 've')
            ->set('ve.visitorLanding', ':new_visitor_landing_id')
            ->where('ve.visitorLanding = :old_visitor_landing_id')
            ->andWhere('ve.type != :visitor_type')
            ->setParameter('new_visitor_landing_id', $newVisitorLanding->getId())
            ->setParameter('old_visitor_landing_id', $oldVisitorLanding->getId())
            ->setParameter('visitor_type', 'VisitorLandingCreated')
            ->getQuery();

        return $q->execute();
    }

    public function findAffiliateReferralInOrder(Order $order)
    {
        $articlesId = [];

        foreach ($order->getOrdersDetail() as $orderDetail) {
            $articlesId[] = $orderDetail->getArticle()->getId();
        }

        $qb = $this->createQueryBuilder('ve')
            ->select('ve')
            ->join('ve.visitorLanding', 'vl', 'WITH', 'vl.id = :visitor_landing_id')
            ->where('ve.article IN (' . implode(',', $articlesId) . ')')
            ->setParameter('visitor_landing_id', $order->getUser()->getVisitorLanding()->getId());


        $result = $qb->getQuery()->getResult();

        return  (count($result) > 0 ? $result[count($result) - 1] : null);
    }

    public function getAllIps(VisitorEvent $visitorEvent)
    {
        $qb = $this->createQueryBuilder('ve')
            ->select('ve.ip')
            ->where('ve.visitorLanding = :visitor_landing_id')
            ->setParameter('visitor_landing_id', $visitorEvent->getVisitorLanding()->getId());

        return $qb->getQuery()->getResult();
    }

    public function getAllIpsByVisitorLanding(VisitorLanding $visitorLanding)
    {
        $qb = $this->createQueryBuilder('ve')
            ->select('ve.ip')
            ->join('ve.visitorLanding', 'vl', 'WITH', 've.visitorLanding = vl.id')
            ->where('vl.id = :visitor_landing_id')
            ->setParameter('visitor_landing_id', $visitorLanding->getId());

        return $qb->getQuery()->getResult();
    }

    public function findOneById(int $id)
    {
        return $this->find($id);
    }
}
