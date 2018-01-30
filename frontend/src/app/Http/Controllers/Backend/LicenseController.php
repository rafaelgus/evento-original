<?php
namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\StoreLicenseRequest;
use App\Http\Requests\Backend\UpdateLicenseRequest;
use EventoOriginal\Core\Services\LicenseService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class LicenseController
{
    const INGREDIENT_CREATE_ROUTE = '/management/licenses/create';

    protected $licenseService;

    public function __construct(LicenseService $licenseService)
    {
        $this->licenseService = $licenseService;
    }

    public function index()
    {
        return view('backend.admin.licenses.index');
    }

    public function create()
    {
        return view('backend.admin.licenses.create');
    }

    public function edit(int $id)
    {
        $license = $this->licenseService->findOneById($id);
        return view('backend.admin.licenses.edit')->with(['license' => $license]);
    }

    public function store(StoreLicenseRequest $request)
    {
        $this->licenseService->create($request->input('name'));

        Session::flash('message', trans('backend/messages.confirmation.create.licenses'));

        return redirect()->to(self::INGREDIENT_CREATE_ROUTE);
    }

    public function update(int $id, UpdateLicenseRequest $request)
    {
        $license = $this->licenseService->findOneById($id);

        $this->licenseService->update($license, $request->input('name'));

        Session::flash('message', trans('backend/messages.confirmation.edit.license'));

        return redirect()->to('/management/licenses/'. $license->getId() .'/edit');
    }

    public function getDataTables()
    {
        $licenses = $this->licenseService->findAll('es');
        $licenceCollection = new Collection();

        foreach ($licenses as $license) {
            $licenceCollection->push([
                'id' => $license->getId(),
                'name' => $license->getName()
            ]);
        }

        return Datatables::of($licenceCollection)->make(true);
    }

    public function getAll()
    {
        $licenses = $this->licenseService->findAll();

        $licenseParsed = [];

        foreach ($licenses as $license) {
            $licenseParsed[] = ['id' => $license->getId(), 'name' => $license->getName()];
        }

        return $licenseParsed;
    }
}