<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use EventoOriginal\Core\Entities\User;
use EventoOriginal\Core\Services\PayoutService;

class PayoutController extends Controller
{
    private $payoutService;

    public function __construct(PayoutService $payoutService)
    {
        $this->payoutService = $payoutService;
    }

    public function getAll(User $user)
    {
        $payouts = $this->payoutService->getAllByUser(current_user());

        return view('frontend/profile.payouts.index')->with(['payouts' => $payouts]);
    }
}
