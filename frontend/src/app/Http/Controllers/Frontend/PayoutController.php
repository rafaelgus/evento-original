<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Services\PayoutService;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    private $payoutService;

    public function __construct(PayoutService $payoutService)
    {
        $this->payoutService = $payoutService;
    }

    public function getAllPaginated(Request $request)
    {
        $page = $request->input('page') ?: 1;

        $payouts = $this->payoutService->getAllByUserPaginated(current_user(), $page);

        return view('frontend/profile.payouts.index')->with(['payouts' => $payouts]);
    }
}
