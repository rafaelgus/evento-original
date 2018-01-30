<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHealthyRequest;
use App\Http\Requests\UpdateHealthyRequest;
use EventoOriginal\Core\Services\HealthyService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class HealthyController extends Controller
{
    private $healthyService;

    const HEALTHY_ROUTE = '/management/healthy';
    const HEALTHY_CREATE_ROUTE = '/management/healthy/create';

    public function __construct(HealthyService $healthyService)
    {
        $this->healthyService = $healthyService;
    }

    public function index()
    {
        return view('backend.admin.healthy.index');
    }

    public function create()
    {
        return view('backend.admin.healthy.create');
    }

    public function store(StoreHealthyRequest $request)
    {
        $this->healthyService->create($request->input('name'));

        Session::flash('message', trans('backend/messages.confirmation.create.healthy'));

        return redirect()->to(self::HEALTHY_CREATE_ROUTE);
    }

    public function edit(int $id)
    {
        $healthy = $this->healthyService->findOneById($id, 'es');

        return view('backend.admin.healthy.edit')->withHealthy($healthy);
    }

    public function update(UpdateHealthyRequest $request, int $id)
    {
        $healthy = $this->healthyService->findOneById($id, 'es');

        $this->healthyService->update($healthy, $request->input('name'));

        Session::flash('message', trans('backend/messages.confirmation.create.healthy'));

        return redirect()->to(self::HEALTHY_ROUTE);
    }

    public function getDatatable()
    {
        $healthys = $this->healthyService->findAll('es');
        $healthyCollection = new Collection();

        foreach ($healthys as $healthy) {
            $healthyCollection->push([
                'id' => $healthy->getId(),
                'name' => $healthy->getName()
            ]);
        }

        return Datatables::of($healthyCollection)->make(true);
    }

    public function getAllHealthy()
    {
        $healthys = $this->healthyService->findAll('es');
        $parsedHealthy = [];

        foreach ($healthys as $healthy) {
            $parsedHealthy[] = ['id' => $healthy->getId(), 'name' => $healthy->getName()];
        }

        return $parsedHealthy;
    }
}
