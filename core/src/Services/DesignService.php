<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Design;
use EventoOriginal\Core\Entities\Designer;
use EventoOriginal\Core\Enums\DesignStatus;
use EventoOriginal\Core\Persistence\Repositories\DesignRepository;
use Exception;

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

    public function saveDesign(Designer $designer, string $name, string $json, string $description = null)
    {
        $design = new Design();
        $design->setDesigner($designer);
        $design->setName($name);
        $design->setJson($json);
        $design->setDescription($description);

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
            $image = $this->storageService->savePicture(array_get($data, 'image'), 'designs');
            $design->setImage($image);
        }

        $design->setDescription(array_get($data, 'description'));
        $design->setStatus(DesignStatus::CREATED);

        $this->designRepository->save($design);

        return $design;
    }
}
