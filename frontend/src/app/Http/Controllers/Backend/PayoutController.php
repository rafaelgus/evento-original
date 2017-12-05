<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use EventoOriginal\Core\Services\MovementService;
use EventoOriginal\Core\Services\PayoutService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PayoutController extends Controller
{
    private $payoutService;
    private $movementService;

    public function __construct(PayoutService $payoutService, MovementService $movementService)
    {
        $this->payoutService = $payoutService;
        $this->movementService = $movementService;
    }

    public function index(Request $request)
    {
        $page = $request->input('page') ?: 1;

        $payouts = $this->payoutService->getAllPaginated($page);

        return view('backend/admin.payouts.index')->with(['payouts' => $payouts]);
    }

    public function showPendents(Request $request)
    {
        $page = $request->input('page') ?: 1;

        $payouts = $this->payoutService->getAllPendentsPaginated($page);

        return view('backend/admin.payouts.pendents')->with(['payouts' => $payouts]);
    }

    public function show(int $id)
    {
        $payout = $this->payoutService->findById($id);

        if (!$payout) {
           abort(404);
        }

        $lastMovements = $this->movementService->findLastMovementsByUser($payout->getUser(), 30);

        return view('backend/admin.payouts.show')->with(['payout' => $payout, 'lastMovements' => $lastMovements]);
    }

    public function send(Request $request, int $id)
    {
        $payout = $this->payoutService->findById($id);

        if (!$payout) {
            abort(400);
        }

        try {
            $this->payoutService->send($payout);

            Session::flash('message', "Pago enviado con exito");
        } catch (Exception $exception) {
            Session::flash('message-error', "Error: " . $exception->getMessage());
        }

        return redirect()->route('admin.payouts.show', ['id' => $id]);
    }

    public function cancel(Request $request, int $id)
    {
        $payout = $this->payoutService->findById($id);

        if (!$payout) {
            abort(400);
        }

        try {
            $this->payoutService->cancel($payout);

            Session::flash('message', "Pago cancelado con exito");
        } catch (Exception $exception) {
            Session::flash('message-error', "Error: " . $exception->getMessage());
        }

        return redirect()->route('admin.payouts.show', ['id' => $id]);
    }
}
