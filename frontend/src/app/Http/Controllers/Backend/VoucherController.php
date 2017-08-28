<?php
namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\StoreVoucherRequest;
use App\Http\Requests\Backend\UpdateVoucherRequest;
use EventoOriginal\Core\Services\CategoryService;
use EventoOriginal\Core\Services\VoucherService;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class VoucherController
{
    private $voucherService;
    private $categoryService;

    const TYPE_RELATIVE = 'relative';
    const TYPE_ABSOLUTE = 'absolute';

    public function __construct(
        VoucherService $voucherService,
        CategoryService $categoryService
    ) {
        $this->voucherService = $voucherService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return view('backend.admin.vouchers.index');
    }

    public function create()
    {
        $categories = $this->categoryService->findAll(App::getLocale());

        return view('backend.admin.vouchers.create')
            ->with('categories', $categories);
    }

    public function edit(int $id)
    {
        $voucher = $this->voucherService->findById($id);

        return view('backend.admin.vouchers.edit')
            ->with($voucher);
    }

    public function store(StoreVoucherRequest $request)
    {
        $data = $request->all();

        $hasCategory = $request->has('category');

        if ($data['type'] === self::TYPE_ABSOLUTE )
        $this
            ->voucherService
            ->create(
                $data['code'],
                $data['type'],
                null,
                $data['amount'],
                ($hasCategory)? $data['category']: null
            );
        elseif ($data['type'] === self::TYPE_RELATIVE) {
            $this
                ->voucherService
                ->create(
                    $data['code'],
                    $data['type'],
                    $data['value'],
                    null,
                    ($hasCategory)? $data['category']: null
                );
        }
        Session::flash('message', trans('backend/messages.confirmation.create.voucher'));


    }

    public function update(int $id, UpdateVoucherRequest $request)
    {
        $voucher = $this->voucherService->findById($id);

        $voucher->setCode($request->input('code'));

        if (self::TYPE_RELATIVE) {
            $voucher->setValue($request->input('value'));
        } elseif (self::TYPE_ABSOLUTE) {
            $voucher->setAmount($request->input('amount'));
        }

        $this->voucherService->save($voucher);

        Session::flash('message', trans('backend/messages.confirmation.create.voucher'));
    }
}