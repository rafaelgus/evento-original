<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreDesignMaterialTypeRequest;
use App\Http\Requests\Backend\UpdateDesignMaterialTypeRequest;
use EventoOriginal\Core\Services\DesignMaterialTypeService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class DesignMaterialTypeController extends Controller
{
    private $designMaterialTypeService;

    const DESIGN_MATERIAL_TYPE_ROUTE = '/management/design-material-type';
    const DESIGN_MATERIAL_TYPE_CREATE = '/management/design-material-type/create';

    public function __construct(DesignMaterialTypeService $designMaterialTypeService)
    {
        $this->designMaterialTypeService = $designMaterialTypeService;
    }

    public function index()
    {
        return view('backend.admin.design_material_types.index');
    }

    public function create()
    {
        return view('backend.admin.design_material_types.create');
    }

    public function store(StoreDesignMaterialTypeRequest $request)
    {
        $this->designMaterialTypeService->create($request->all());

        Session::flash('message', trans('backend/messages.confirmation.create.design_material_type'));

        return redirect()->to(self::DESIGN_MATERIAL_TYPE_ROUTE);
    }

    public function edit(int $id)
    {
        $designMaterialType = $this->designMaterialTypeService->findOneById($id);

        return view('backend.admin.design_material_types.edit')->with('designMaterialType', $designMaterialType);
    }

    public function update(UpdateDesignMaterialTypeRequest $request, int $id)
    {
        $designMaterialType = $this->designMaterialTypeService->findOneById($id);

        if (!$designMaterialType) {
            Session::flash('message-error', trans('backend/messages.error.create.update'));
        }

        $this->designMaterialTypeService->update($designMaterialType, $request->all());

        Session::flash('message', trans('backend/messages.confirmation.create.design_material_type'));

        return redirect()->to(self::DESIGN_MATERIAL_TYPE_ROUTE);
    }

    /**
     * @param int $id
     */
    public function remove(int $id)
    {
        try {
            $this->designMaterialTypeService->remove($id);

            Session::flash('message', trans('backend/messages.confirmation.remove'));
        } catch (\Throwable $exception) {
            Session::flash('message-error', trans('backend/messages.error.create.update'));
        }

        return redirect()->to(self::DESIGN_MATERIAL_TYPE_ROUTE);
    }

    public function getDatatable()
    {
        $designMaterialTypes = $this->designMaterialTypeService->findAll();
        $designMaterialTypesCollection = new Collection();

        foreach ($designMaterialTypes as $designMaterialType) {
            $designMaterialTypesCollection->push([
                'id' => $designMaterialType->getId(),
                'name' => $designMaterialType->getName(),
                'description' => $designMaterialType->getDescription(),
            ]);
        }

        return Datatables::of($designMaterialTypesCollection)->make(true);
    }
}
