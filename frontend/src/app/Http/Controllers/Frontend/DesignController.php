<?php
namespace App\Http\Controllers\Frontend;

use EventoOriginal\Core\Services\CircularDesignVariantService;

class DesignController
{
    private $circularDesignVariantService;

    /**
     * DesignController constructor.
     * @param CircularDesignVariantService $circularDesignVariantService
     */
    public function __construct(
        CircularDesignVariantService $circularDesignVariantService
    ) {
        $this->circularDesignVariantService = $circularDesignVariantService;
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
