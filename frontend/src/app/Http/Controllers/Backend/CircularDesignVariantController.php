<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreCircularDesignVariantRequest;
use App\Http\Requests\Backend\UpdateCircularDesignVariantRequest;
use EventoOriginal\Core\Services\CircularDesignVariantService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;

class CircularDesignVariantController extends Controller
{
    const CIRCULAR_DESIGN_VARIANT_ROUTE = '/management/circular-design-variant';
    const CIRCULAR_DESIGN_VARIANT_CREATE = '/management/circular-design-variant/create';

    /**
     * @var CircularDesignVariantService
     */
    private $circularDesignVariantService;

    /**
     * CircularDesignVariantController constructor.
     * @param CircularDesignVariantService $circularDesignVariantService
     */
    public function __construct(CircularDesignVariantService $circularDesignVariantService)
    {
        $this->circularDesignVariantService = $circularDesignVariantService;
    }

    public function index()
    {
        return view('backend.admin.circular_design_variants.index');
    }

    public function create()
    {
        return view('backend.admin.circular_design_variants.create');
    }

    public function store(StoreCircularDesignVariantRequest $request)
    {
        $this->circularDesignVariantService->create($request->all());

        Session::flash('message', trans('backend/messages.confirmation.create.circular_design_variant'));

        return redirect()->to(self::CIRCULAR_DESIGN_VARIANT_ROUTE);
    }

    public function edit(int $id)
    {
        $circularDesignVariant = $this->circularDesignVariantService->findOneById($id);

        return view('backend.admin.design_material_sizes.edit')->with('circularDesignVariant', $circularDesignVariant);
    }

    public function update(UpdateCircularDesignVariantRequest $request, int $id)
    {
        $circularDesignVariant = $this->circularDesignVariantService->findOneById($id);

        if (!$circularDesignVariant) {
            Session::flash('message-error', trans('backend/messages.error.create.update'));
        }

        $this->circularDesignVariantService->update($circularDesignVariant, request()->all());

        Session::flash('message', trans('backend/messages.confirmation.create.circular_design_variant'));

        return redirect()->to(self::CIRCULAR_DESIGN_VARIANT_CREATE);
    }

    /**
     * @param int $id
     */
    public function remove(int $id)
    {
        try {
            $this->circularDesignVariantService->remove($id);

            Session::flash('message', trans('backend/messages.confirmation.remove'));
        } catch (\Throwable $exception) {
            Session::flash('message-error', trans('backend/messages.error.create.update'));
        }

        return redirect()->to(self::CIRCULAR_DESIGN_VARIANT_ROUTE);
    }

    public function getDatatable()
    {
        $circularDesignVariants = $this->circularDesignVariantService->findAll();
        $circularDesignVariantsCollection = new Collection();

        foreach ($circularDesignVariants as $circularDesignVariant) {
            $circularDesignVariantsCollection->push([
                'id' => $circularDesignVariant->getId(),
                'name' => $circularDesignVariant->getName(),
            ]);
        }

        return Datatables::of($circularDesignVariantsCollection)->make(true);
    }
}
