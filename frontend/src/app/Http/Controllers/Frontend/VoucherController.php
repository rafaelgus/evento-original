<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Requests\UseVoucherRequest;
use EventoOriginal\Core\Services\VoucherService;
use Gloudemans\Shoppingcart\Facades\Cart;

class VoucherController
{
    private $voucherService;

    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    public function useVoucher(UseVoucherRequest $request)
    {
        $voucher = $this->voucherService->findByCode($request->input('code'));

        $total = Cart::total();

        $this->voucherService->useVoucher($voucher);
        $discount = $this->voucherService->getDiscountAmount($voucher, $total);

        Cart::instance('shopping')->add(
            $voucher->getCode(),
            'Descuento',
            1,
            - $discount
        );

        return response('voucher added', 200);
    }
}