<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Design;
use EventoOriginal\Core\Entities\Designer;
use EventoOriginal\Core\Enums\DesignSource;
use EventoOriginal\Core\Enums\DesignStatus;
use EventoOriginal\Core\Persistence\Repositories\DesignRepository;
use Exception;
use Imagecow\Image;
use Imagecow\Utils\SvgExtractor;
use Imagick;
use ImagickPixel;
use InvalidArgumentException;

class DesignService
{
    private $designRepository;
    private $storageService;

    /**
     * DesignService constructor.
     * @param DesignRepository $designRepository
     * @param StorageService $storageService
     */
    public function __construct(
        DesignRepository $designRepository,
        StorageService $storageService
    ) {
        $this->designRepository = $designRepository;
        $this->storageService = $storageService;
    }

    public function findOneById(int $id)
    {
        return $this->designRepository->findOneById($id);
    }

    public function saveDesignerDesign(array $data)
    {
        $design = new Design();
        $design->setDesigner($data['designer']);

        if (array_key_exists('name', $data)) {
            $design->setName(array_get($data, 'name'));
        } else {
            $design->setName('Design ' . uniqid());
        }

        if (array_key_exists('json', $data)) {
            $design->setJson(array_get($data, 'json'));

            $img = array_get($data, 'image');

            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            $fileName = uniqid() . 'png';

            file_put_contents($fileName, $fileData);

            $image = $this->storageService->savePicture($fileName, 'designs', 'png');

            unlink($fileName);

            $design->setImage($image);
            $design->setSource(DesignSource::EDITOR);
        } elseif (array_key_exists('image', $data)) {
            $imgFile = array_get($data, 'image');

            $image = $this->storageService->savePicture(
                array_get($data, 'image'),
                'designs',
                $imgFile->getClientOriginalExtension()
            );

            $design->setImage($image);
            $design->setSource(DesignSource::TEMPLATE);
        } else {
            throw new InvalidArgumentException("Invalid design");
        }

        $this->designRepository->save($design);

        return $design;
    }

    public function getAllByDesignerPaginated(Designer $designer)
    {
        return $this->designRepository->getAllByDesignerPaginated($designer);
    }

    /**
     * @param Designer $designer
     * @param string $status
     * @return \Illuminate\Pagination\LengthAwarePaginator
     * @throws Exception
     */
    public function getAllByDesignerAndStatusPaginated(Designer $designer, string $status)
    {
        if (!DesignStatus::isValid($status)) {
            throw new Exception("Invalid design status");
        }

        return $this->designRepository->getAllByDesignerAndStatusPaginated($designer, $status);
    }

    public function create(Designer $designer, array $data)
    {
        $design = new Design();

        $design->setDesigner($designer);
        $design->setName(array_get($data, 'name'));

        if (isset($data['json'])) {
            $design->setJson(array_get($data, 'json'));
        }

        if (isset($data['image'])) {
            $image = $this->storageService->savePicture(
                array_get($data, 'image'),
                'designs',
                $data['image']->getClientOriginalExtension()
            );
            $design->setImage($image);
        }

        $design->setDescription(array_get($data, 'description'));
        $design->setStatus(DesignStatus::CREATED);

        $this->designRepository->save($design);

        return $design;
    }
}
