<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreBrandRequest;
use App\Http\Requests\Backend\UpdateBrandRequest;
use EventoOriginal\Core\Services\BrandService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class BrandController extends Controller
{
    private $brandService;

    const BRAND_ROUTE = '/management/brand';
    const BRAND_CREATE_ROUTE = '/management/brand/create';

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index()
    {
        return view('backend.admin.brands.index');
    }

    public function create()
    {
        return view('backend.admin.brands.create');
    }

    public function store(StoreBrandRequest $request)
    {
        $this->brandService->create($request->input('name'));

        Session::flash('message', trans('backend/messages.confirmation.create.brand'));

        return redirect()->to(self::BRAND_CREATE_ROUTE);
    }

    public function edit(int $id)
    {
        $brand = $this->brandService->findOneById($id, 'es');

        return view('backend.admin.brands.edit')->withBrand($brand);
    }

    public function update(UpdateBrandRequest $request, int $id)
    {
        $brand = $this->brandService->findOneById($id, 'es');

        $this->brandService->update($brand, $request->input('name'));

        Session::flash('message', trans('backend/messages.confirmation.create.brand'));

        return redirect()->to(self::BRAND_ROUTE);
    }

    public function getDatatable()
    {
        $brands = $this->brandService->findAll('es');
        $brandsCollection = new Collection();

        foreach ($brands as $brand) {
            $brandsCollection->push([
                'id' => $brand->getId(),
                'name' => $brand->getName()
            ]);
        }

        return Datatables::of($brandsCollection)->make(true);
    }

    public function getAllBrands()
    {
        $brands = $this->brandService->findAll();
        $parsedBrands = [];

        foreach ($brands as $brand){
            $parsedBrands[] = ['id' => $brand->getId(), 'name' => $brand->getName()];
        }

        return $parsedBrands;
    }
}
