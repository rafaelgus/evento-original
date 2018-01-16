<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreMaterialDesignSizeRequest;
use App\Http\Requests\Backend\UpdateMaterialDesignSizeRequest;
use EventoOriginal\Core\Services\DesignMaterialSizeService;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;

class DesignMaterialSizeController extends Controller
{
    private $designMaterialSizeService;

    const DESIGN_MATERIAL_SIZE_ROUTE = '/management/design-material-size';
    const DESIGN_MATERIAL_SIZE_CREATE = '/management/design-material-size/create';

    public function __construct(DesignMaterialSizeService $designMaterialSizeService)
    {
        $this->designMaterialSizeService = $designMaterialSizeService;
    }

    public function index()
    {
        return view('backend.admin.design_material_sizes.index');
    }

    public function create()
    {
        return view('backend.admin.design_material_sizes.create');
    }

    public function store(StoreMaterialDesignSizeRequest $request)
    {
        $this->designMaterialSizeService->create($request->all());

        Session::flash('message', trans('backend/messages.confirmation.create.design_material_size'));

        return redirect()->to(self::DESIGN_MATERIAL_SIZE_ROUTE);
    }

    public function edit(int $id)
    {
        $designMaterialSize = $this->designMaterialSizeService->findOneById($id);

        return view('backend.admin.design_material_sizes.edit')->with('designMaterialSize', $designMaterialSize);
    }

    public function update(UpdateMaterialDesignSizeRequest $request, int $id)
    {
        $designMaterialSize = $this->designMaterialSizeService->findOneById($id);

        if (!$designMaterialSize) {
            Session::flash('message-error', trans('backend/messages.error.create.update'));
        }

        $this->designMaterialSizeService->update($designMaterialSize, request()->all());

        Session::flash('message', trans('backend/messages.confirmation.create.design_material_size'));

        return redirect()->to(self::DESIGN_MATERIAL_SIZE_ROUTE);
    }

    /**
     * @param int $id
     */
    public function remove(int $id)
    {
        try {
            $this->designMaterialSizeService->remove($id);

            Session::flash('message', trans('backend/messages.confirmation.remove'));
        } catch (\Throwable $exception) {
            Session::flash('message-error', trans('backend/messages.error.create.update'));
        }

        return redirect()->to(self::DESIGN_MATERIAL_SIZE_ROUTE);
    }

    public function getDatatable()
    {
        $designMaterialSizes = $this->designMaterialSizeService->findAll();
        $designMaterialSizesCollection = new Collection();

        foreach ($designMaterialSizes as $designMaterialSize) {
            $designMaterialSizesCollection->push([
                'id' => $designMaterialSize->getId(),
                'name' => $designMaterialSize->getName(),
                'horizontalSize' => $designMaterialSize->getHorizontalSize(),
                'verticalSize' => $designMaterialSize->getVerticalSize(),
            ]);
        }

        return Datatables::of($designMaterialSizesCollection)->make(true);
    }
}
