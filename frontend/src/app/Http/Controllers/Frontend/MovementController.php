<?php
namespace App\Http\Controllers\Frontend;

use EventoOriginal\Core\Services\MovementService;
use Illuminate\Http\Request;

class MovementController
{
    private $movementService;

    public function __construct(
        MovementService $movementService
    ) {
        $this->movementService = $movementService;
    }

    public function getAllPaginated(Request $request)
    {
        $page = $request->input('page') ?: 1;

        $movements = $this->movementService->getAllByUserPaginated(current_user(), $page);

        return view('frontend/profile.movements')->with(['movements' => $movements]);
    }
}
