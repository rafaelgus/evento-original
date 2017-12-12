<?php
namespace EventoOriginal\Core\Services;

use EventoOriginal\Core\Entities\Design;
use EventoOriginal\Core\Entities\Designer;
use EventoOriginal\Core\Persistence\Repositories\DesignRepository;

class DesignService
{
    private $designRepository;

    public function __construct(DesignRepository $designRepository)
    {
        $this->designRepository = $designRepository;
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

    }
}
