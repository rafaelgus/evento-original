<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use Doctrine\ORM\Query;
use EventoOriginal\Core\Entities\Color;
use Gedmo\Translatable\TranslatableListener;

class ColorRepository extends BaseRepository
{
    public function findOneById(int $id)
    {
        return $this->find($id);
    }

    public function findOneByName(string $name)
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function save(Color $color, bool $flush = true)
    {
        $this->getEntityManager()->persist($color);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(Color $color, bool $flush = true)
    {
        $this->getEntityManager()->remove($color);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneInLocale(int $id, string $locale)
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c')
            ->where('c.id = :id')
            ->setMaxResults(1)
            ->setParameter('id', $id);
        ;

        $query = $qb->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            $locale
        );

        $result = $query->getOneOrNullResult();

        $query->setHint(
            \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
            'es'
        );

        return $result;
    }
}
