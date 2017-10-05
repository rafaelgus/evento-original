<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\VisitorEvent;
use EventoOriginal\Core\Entities\VisitorLanding;

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
        $q = $qb->update('visitor_event', 've')
            ->set('ve.visitor_landing', '?new_visitor_landing_id')
            ->where('ve.visitor_landing = ?old_visitor_landing_id')
            ->setParameter('new_visitor_landing_id', $newVisitorLanding->getId())
            ->setParameter('old_visitor_landing_id', $oldVisitorLanding->getId())
            ->getQuery();

        return $q->execute();
    }
}
