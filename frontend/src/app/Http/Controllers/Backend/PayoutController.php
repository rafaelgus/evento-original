<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use EventoOriginal\Core\Services\PayoutService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PayoutController extends Controller
{
    private $payoutService;

    public function __construct(PayoutService $payoutService)
    {
        $this->payoutService = $payoutService;
    }

    public function index(Request $request)
    {
        $page = $request->input('page') ?: 1;

        $payouts = $this->payoutService->getAllPaginated($page);

        return view('backend/admin.payouts.index')->with(['payouts' => $payouts]);
    }

    public function show(int $id)
    {
        $payout = $this->payoutService->findById($id);

        if (!$payout) {
           abort(404);
        }

        return view('backend/admin.payouts.show')->with(['payout' => $payout]);
    }

    public function send(Request $request, int $id)
    {
        $payout = $this->payoutService->findById($id);

        if (!$payout) {
            abort(400);
        }

        dd($payout);

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
