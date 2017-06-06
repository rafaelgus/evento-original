<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreFlavourRequest;
use EventoOriginal\Core\Services\FlavourService;
use Illuminate\Support\Facades\Session;

class FlavourController extends Controller
{
    private $flavourService;

    const FLAVOUR_ROUTE = '/management/flavour';
    const FLAVOUR_CREATE_ROUTE = '/management/flavour/create';

    public function __construct(FlavourService $flavourService)
    {
        $this->flavourService = $flavourService;
    }

    public function create()
    {
        return view('backend.admin.flavours.create');
    }

    public function store(StoreFlavourRequest $request)
    {
        $this->flavourService->create($request->input('name'));

        Session::flash('message', trans('backend/messages.confirmation.create.flavour'));

        return redirect()->to(self::FLAVOUR_CREATE_ROUTE);
    }
}
