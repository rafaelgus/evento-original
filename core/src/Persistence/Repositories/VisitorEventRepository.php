<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use EventoOriginal\Core\Entities\Order;
use EventoOriginal\Core\Entities\OrderDetail;
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

        logger()->info($q->getSQL());

        return $q->execute();
    }

    public function findAffiliateReferralInOrder(Order $order)
    {
        $rsm = new ResultSetMappingBuilder($this->getEntityManager());
        $rsm->addRootEntityFromClassMetadata(VisitorEvent::class, 've');

        $query = $this->getEntityManager()->createNativeQuery(
            'SELECT * FROM visitor_events ve JOIN order_detail AS od ON 
od.order_id = :order_id AND od.article_id = ve.article_id = od.article_id 
WHERE ve.visitor_landing_id = :visitor_landing__id', $rsm);
        $query->setParameter('order_id', $order->getId());
        $query->setParameter('visitor_landing_id', $order->getUser()->getVisitorLanding()->getId());

        $visitorEvent = $query->getOneOrNullResult();

        return $visitorEvent;
    }
}
