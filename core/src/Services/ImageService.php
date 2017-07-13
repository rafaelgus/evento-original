<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Article;
use EventoOriginal\Core\Entities\Image;
use EventoOriginal\Core\Persistence\Repositories\ImageRepository;

class ImageService
{
    private $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    /**
     * @param string $path
     * @param string $description
     * @param Article $article;
     * @return Image
     */
    public function create(
        string $path,
        string $description,
        Article $article
    ): Image {
        $image = new Image();
        $image->setPath($path);
        $image->setDescription($description);
        $image->setArticle($article);
        $this->imageRepository->save($image);

        return $image;
    }

    /**
     * @param int $id
     * @return null|Image
     */
    public function findById(int $id)
    {
        return $this->imageRepository->find($id);
    }
}