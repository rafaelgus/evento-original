<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\PDF;
use EventoOriginal\Core\Enums\DesignStatus;
use EventoOriginal\Core\Enums\DesignType;
use EventoOriginal\Core\Services\DesignService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class DesignController extends Controller
{
    /**
     * @var DesignService
     */
    private $designService;

    /**
     * DesignController constructor.
     * @param DesignService $designService
     */
    public function __construct(
        DesignService $designService
    ) {
        $this->designService = $designService;
    }

    public function inReview()
    {
        $designs = $this->designService->findAllByStatusPaginated(DesignStatus::IN_REVIEW);

        return view('backend/admin.designs.in_review')->with(['designs' => $designs]);
    }

    public function show(int $id)
    {
        $design = $this->designService->findOneById($id);

        if (!$design) {
            abort(404);
        }

        return view('backend/admin.designs.show')->with(['design' => $design]);
    }

    /**
     * @param int $id
     * @return $this
     */
    public function approve(Request $request, int $id)
    {
        $design = $this->designService->findOneById($id);

        if (!$design) {
            abort(404);
        }

        try {
            $this->designService->approve($design);
        } catch (Exception $exception) {
            dd($exception);
        }

        return view('backend/admin.designs.show')->with(['design' => $design]);
    }

    public function rejectForm(int $id)
    {
        $design = $this->designService->findOneById($id);

        if (!$design || $design->getStatus() != DesignStatus::IN_REVIEW) {
            abort(404);
        }

        return view('backend/admin.designs.reject')->with(['design' => $design]);
    }

    public function reject(Request $request, int $id)
    {
        $design = $this->designService->findOneById($id);

        if (!$design) {
            abort(404);
        }

        $this->designService->reject($design, $request->get('observation'));

        return $this->inReview();
    }

    public function download(int $id)
    {
        $design = $this->designService->findOneById($id);

        if (!$design) {
            abort(404);
        }

        if ($design->getType() === DesignType::MUG) {
            return redirect()->to($design->getImage());
        }

        $width = 0;
        $height = 0;

        if ($design->getCircularDesignVariant()) {
            $materialSize = $design->getCircularDesignVariant()->getDesignMaterialSize();

            $width = $materialSize->getHorizontalSizeInPx();
            $height = $materialSize->getVerticalSizeInPx();
        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView(
            'backend/admin.designs.download_pdf',
            [
                'design' => $design,
                'width' => $width,
                'height' => $height
            ]
        );
        $pdf->setPaper("a4");


        return $pdf->stream();
    }
}
