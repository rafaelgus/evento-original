<?php
/**
 * Created by PhpStorm.
 * User: martinchos
 * Date: 30/06/17
 * Time: 17:33
 */

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
}