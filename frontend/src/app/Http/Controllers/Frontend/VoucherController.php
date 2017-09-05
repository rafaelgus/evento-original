<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Requests\UseVoucherRequest;
use EventoOriginal\Core\Services\VoucherService;
use Exception;
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
        try {
            $voucher = $this->voucherService->findByCode($request->input('code'));

            $total = Cart::instance('shopping')->total();

            $this->voucherService->useVoucher($request->input('code'));
            $discount = $this->voucherService->getDiscountAmount($voucher, $total);

            Cart::instance('discount')->add(
                $voucher->getCode(),
                'Descuento',
                1,
                $discount
            );

            return response('voucher added', 200);
        } catch (Exception $exception) {
            return response('voucher en uso o incorrecto',400);
        }

    }
}