<?php
namespace App\Http\Controllers\Frontend;

use EventoOriginal\Core\Persistence\Repositories\CircularDesignVariantDetailRepository;
use EventoOriginal\Core\Services\CircularDesignVariantService;
use EventoOriginal\Core\Services\DesignService;

class DesignController
{
    private $circularDesignVariantService;
    /**
     * @var DesignService
     */
    private $designService;
    /**
     * @var CircularDesignVariantDetailRepository
     */
    private $circularDesignVariantDetailRepository;

    /**
     * DesignController constructor.
     * @param CircularDesignVariantService $circularDesignVariantService
     * @param DesignService $designService
     * @param CircularDesignVariantDetailRepository $circularDesignVariantDetailRepository
     */
    public function __construct(
        CircularDesignVariantService $circularDesignVariantService,
        DesignService $designService,
        CircularDesignVariantDetailRepository $circularDesignVariantDetailRepository
    ) {
        $this->circularDesignVariantService = $circularDesignVariantService;
        $this->designService = $designService;
        $this->circularDesignVariantDetailRepository = $circularDesignVariantDetailRepository;
    }

    public function circularDesignVariants()
    {
        $circularDesignVariants = $this->circularDesignVariantService->findAll();

        return view('frontend/edible_paper.circular_design_variants')->with([
            'circularDesignVariants' => $circularDesignVariants,
        ]);
    }

    public function circularDesignVariantsEditor(int $id)
    {
        $circularDesignVariant = $this->circularDesignVariantService->findOneById($id);

        if (!$circularDesignVariant) {
            abort(404);
        }

        return view('frontend/designer.editor_edible_paper_a4')->with(
            [
                'circularDesignVariant' => $circularDesignVariant
            ]
        );
    }

    public function createDesign()
    {
        return view('frontend/designs.create_design');
    }

    public function createEdiblePaper()
    {
        $variants = $this->circularDesignVariantService->findAll();

        return view('frontend/designs.create_edible_paper')->with([
            'variants' => $variants,
        ]);
    }

    public function designEdiblePaper(int $id)
    {
        $circularDesignVariant = $this->circularDesignVariantService->findOneById($id);

        if (!$circularDesignVariant) {
            abort(404);
        }

        return view('frontend/designs.design_edible_paper')->with([
            'circularDesignVariant' => $circularDesignVariant,
        ]);
    }
}
