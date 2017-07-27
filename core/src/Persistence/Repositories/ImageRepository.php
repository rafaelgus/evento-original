<?php
namespace EventoOriginal\Core\Persistence\Repositories;

use EventoOriginal\Core\Entities\Image;

class ImageRepository extends BaseRepository
{
    public function save(Image $image, bool $flush = true)
    {
        $this->getEntityManager()->persist($image);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function delete(Image $image, bool $flush = true)
    {
        $this->getEntityManager()->remove($image);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}