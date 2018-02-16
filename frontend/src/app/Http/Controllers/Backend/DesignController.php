<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use EventoOriginal\Core\Enums\DesignStatus;
use EventoOriginal\Core\Services\DesignService;
use Illuminate\Http\Request;

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

    public function approve(int $id)
    {
        $design = $this->designService->findOneById($id);

        if (!$design) {
            abort(404);
        }

        $this->designService->approve($design);

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
}
