<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Requests\Backend\StoreDesignRequest;
use EventoOriginal\Core\Services\DesignerService;
use EventoOriginal\Core\Services\DesignService;

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
}
