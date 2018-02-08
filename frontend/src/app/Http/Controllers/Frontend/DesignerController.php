<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Backend\StoreDesignRequest;
use EventoOriginal\Core\Enums\DesignStatus;
use EventoOriginal\Core\Services\CircularDesignVariantService;
use EventoOriginal\Core\Services\DesignerService;
use EventoOriginal\Core\Services\DesignService;
use Illuminate\Http\Request;

class DesignerController
{
    private $designerService;
    private $designService;
    private $circularDesignVariantService;

    public function __construct(
        DesignerService $designerService,
        DesignService $designService,
        CircularDesignVariantService $circularDesignVariantService
    ) {
        $this->designerService = $designerService;
        $this->designService = $designService;
        $this->circularDesignVariantService = $circularDesignVariantService;
    }

    public function showEditor()
    {
        return view('frontend/designer.editor_edible_paper_a4');
    }

    public function storeDesign(StoreDesignRequest $request)
    {
        $designer = current_user()->getDesigner();

        if ($designer) {
            $data = $request->all();
            $data['designer'] = $designer;

            $this->designService->saveDesignerDesign($data);
        }

        return $this->showDesigns();
    }

    public function register()
    {
        return view('frontend/designer.register_user_as_designer');
    }

    public function postRegister(Request $request)
    {
        $user = current_user();

        $this->designerService->create($user, $request->get('nickname'));

        return redirect()->route('designer.myDesigns');
    }

    public function showDesigns()
    {
        $user = current_user();

        $designer = $user->getDesigner();

        if (!$designer) {
            abort(404);
        }

        $designs = $this->designService->getAllByDesignerAndStatusPaginated($designer, DesignStatus::CREATED);

        return view('frontend/designer.my_designs')->with([
            'designs' => $designs,
        ]);
    }

    public function showDesignsInReview()
    {
        $user = current_user();

        $designer = $user->getDesigner();

        if (!$designer) {
            abort(404);
        }

        $designs = $this->designService->getAllByDesignerAndStatusPaginated($designer, DesignStatus::IN_REVIEW);

        return view('frontend/designer.my_designs_in_review')->with([
            'designs' => $designs,
        ]);
    }

    public function showDesignsNeedChanges()
    {
        $user = current_user();

        $designer = $user->getDesigner();

        if (!$designer) {
            abort(404);
        }

        $designs = $this->designService->getAllByDesignerAndStatusPaginated($designer, DesignStatus::NEED_CHANGES);

        return view('frontend/designer.my_designs_need_changes')->with([
            'designs' => $designs,
        ]);
    }

    public function showDesignsPublished()
    {
        $user = current_user();

        $designer = $user->getDesigner();

        if (!$designer) {
            abort(404);
        }

        $designs = $this->designService->getAllByDesignerAndStatusPaginated($designer, DesignStatus::PUBLISHED);

        return view('frontend/designer.my_designs_published')->with([
            'designs' => $designs,
        ]);
    }

    public function create()
    {
        return view('frontend/designer.create_design');
    }

    public function createEdiblePaper()
    {
        $variants = $this->circularDesignVariantService->findAll();

        return view('frontend/designer.create_edible_paper')->with([
            'variants' => $variants,
        ]);
    }

    public function selectEdiblePaper(int $id)
    {
        $variant = $this->circularDesignVariantService->findOneById($id);

        if (!$variant) {
            abort(404);
        }

        return view('frontend/designer.select_edible_paper_variant')->with([
            'variant' => $variant,
        ]);
    }

    public function designEdiblePaper(int $id)
    {
        $circularDesignVariant = $this->circularDesignVariantService->findOneById($id);

        if (!$circularDesignVariant) {
            abort(404);
        }

        return view('frontend/designer.design_edible_paper')->with([
            'circularDesignVariant' => $circularDesignVariant,
        ]);
    }

    public function sendToReview(int $id)
    {
        $design = $this->designService->
    }
}
