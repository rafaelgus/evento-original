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
}
