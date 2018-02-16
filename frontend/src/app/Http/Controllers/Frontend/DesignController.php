<?php
namespace App\Http\Controllers\Frontend;

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
     * DesignController constructor.
     * @param CircularDesignVariantService $circularDesignVariantService
     * @param DesignService $designService
     */
    public function __construct(
        CircularDesignVariantService $circularDesignVariantService,
        DesignService $designService
    ) {
        $this->circularDesignVariantService = $circularDesignVariantService;
        $this->designService = $designService;
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
}
