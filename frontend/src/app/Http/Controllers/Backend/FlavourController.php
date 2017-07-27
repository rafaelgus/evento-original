<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreFlavourRequest;
use App\Http\Requests\Backend\UpdateFlavourRequest;
use EventoOriginal\Core\Services\FlavourService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;

class FlavourController extends Controller
{
    private $flavourService;

    const FLAVOUR_ROUTE = '/management/flavour';
    const FLAVOUR_CREATE_ROUTE = '/management/flavour/create';

    public function __construct(FlavourService $flavourService)
    {
        $this->flavourService = $flavourService;
    }

    public function index()
    {
        return view('backend.admin.flavours.index');
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

    public function edit(int $id)
    {
        $flavour = $this->flavourService->findOneById($id, 'es');

        return view('backend.admin.flavours.edit')->withFlavour($flavour);
    }

    public function update(UpdateFlavourRequest $request, int $id)
    {
        $flavour = $this->flavourService->findOneById($id, 'es');

        $this->flavourService->update($flavour, $request->input('name'));

        Session::flash('message', trans('backend/messages.confirmation.create.flavour'));

        return redirect()->to(self::FLAVOUR_ROUTE);
    }

    public function getDatatable()
    {
        $flavours = $this->flavourService->findAll('es');
        $flavoursCollection = new Collection();

        foreach ($flavours as $flavour) {
            $flavoursCollection->push([
                'id' => $flavour->getId(),
                'name' => $flavour->getName()
            ]);
        }

        return Datatables::of($flavoursCollection)->make(true);
    }

    public function getAllFlavours()
    {
        $flavours = $this->flavourService->findAll('es');
        $parsedFlavours = [];

        foreach ($flavours as $flavour) {
            $parsedFlavours[] = ['id' => $flavour->getId(), 'name' => $flavour->getName()];
        }

        return $parsedFlavours;
    }
}
