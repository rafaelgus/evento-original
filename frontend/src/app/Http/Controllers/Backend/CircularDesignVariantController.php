<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreCircularDesignVariantRequest;
use App\Http\Requests\Backend\UpdateCircularDesignVariantRequest;
use EventoOriginal\Core\Entities\DesignMaterialSize;
use EventoOriginal\Core\Services\CircularDesignVariantService;
use EventoOriginal\Core\Services\DesignMaterialSizeService;
use EventoOriginal\Core\Services\StorageService;
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
     * @var DesignMaterialSize
     */
    private $designMaterialSizeService;
    /**
     * @var StorageService
     */
    private $storageService;

    /**
     * CircularDesignVariantController constructor.
     * @param CircularDesignVariantService $circularDesignVariantService
     * @param DesignMaterialSizeService $designMaterialSizeService
     * @param StorageService $storageService
     */
    public function __construct(
        CircularDesignVariantService $circularDesignVariantService,
        DesignMaterialSizeService $designMaterialSizeService,
        StorageService $storageService
    ) {
        $this->circularDesignVariantService = $circularDesignVariantService;
        $this->designMaterialSizeService = $designMaterialSizeService;
        $this->storageService = $storageService;
    }

    public function index()
    {
        return view('backend.admin.circular_design_variants.index');
    }

    public function create()
    {
        $designMaterialSizes = $this->designMaterialSizeService->findAll();

        return view('backend.admin.circular_design_variants.create')->with([
            'designMaterialSizes' => $designMaterialSizes,
        ]);
    }

    public function store(StoreCircularDesignVariantRequest $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $this->storageService->savePicture($request->file('image'), 'circular-design-variants');

            $data['preview_image'] = $image;
        }

        $this->circularDesignVariantService->create($data);

        Session::flash('message', trans('backend/messages.confirmation.create.circular_design_variant'));

        return redirect()->to(self::CIRCULAR_DESIGN_VARIANT_ROUTE);
    }

    public function edit(int $id)
    {
        $circularDesignVariant = $this->circularDesignVariantService->findOneById($id);
        $designMaterialSizes = $this->designMaterialSizeService->findAll();

        return view('backend.admin.circular_design_variants.edit')
            ->with(
                [
                    'circularDesignVariant' => $circularDesignVariant,
                    'designMaterialSizes' => $designMaterialSizes,
                ]
            );
    }

    public function update(UpdateCircularDesignVariantRequest $request, int $id)
    {
        $circularDesignVariant = $this->circularDesignVariantService->findOneById($id);

        if (!$circularDesignVariant) {
            Session::flash('message-error', trans('backend/messages.error.create.update'));
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $this->storageService->savePicture($request->file('image'), 'circular-design-variants');

            $data['preview_image'] = $image;
        }

        $this->circularDesignVariantService->update($circularDesignVariant, $data);

        Session::flash('message', trans('backend/messages.confirmation.create.circular_design_variant'));

        return redirect()->to(self::CIRCULAR_DESIGN_VARIANT_ROUTE);
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
                'numberOfCircles' => $circularDesignVariant->getNumberOfCircles(),
                'diameterOfCircles' => $circularDesignVariant->getDiameterOfCircles(),
                'designMaterialSize' => $circularDesignVariant->getDesignMaterialSize()->getName(),
            ]);
        }

        return Datatables::of($circularDesignVariantsCollection)->make(true);
    }
}
