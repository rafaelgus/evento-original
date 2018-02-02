<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Backend\StoreDesignRequest;
use EventoOriginal\Core\Enums\DesignStatus;
use EventoOriginal\Core\Services\DesignerService;
use EventoOriginal\Core\Services\DesignService;
use Illuminate\Http\Request;

class DesignerController
{
    private $designerService;
    private $designService;

    public function __construct(
        DesignerService $designerService,
        DesignService $designService
    ) {
        $this->designerService = $designerService;
        $this->designService = $designService;
    }

    public function showEditor()
    {
        return view('frontend/designer.editor_edible_paper_a4');
    }

    public function storeDesign(StoreDesignRequest $request)
    {
        $designer = current_user()->getDesigner();

        if ($designer) {
            $this->designService->saveDesign(
                $designer,
                $request->get('name'),
                $request->get('json'),
                $request->get('description')
            );
        }

        return redirect()->back();
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
}
