<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Requests\UseVoucherRequest;
use EventoOriginal\Core\Entities\Voucher;
use EventoOriginal\Core\Services\CategoryService;
use EventoOriginal\Core\Services\VoucherService;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\App;

class VoucherController
{
    private $voucherService;
    private $categoryService;

    public function __construct(VoucherService $voucherService, CategoryService $categoryService)
    {
        $this->voucherService = $voucherService;
        $this->categoryService = $categoryService;
    }

    public function useVoucher(UseVoucherRequest $request)
    {
        try {
            $voucher = $this->voucherService->findByCode($request->input('code'));

            if ($voucher->getCategory()) {
                $cart = Cart::instance('shopping')->content();

                $totalAmountCategory = 0;

                foreach($cart as $item) {
                    $categoryId = $item->options->category;
                    $category = $this->categoryService->findOneById($categoryId, App::getLocale());

                    $isChildren = $this->categoryService->isChildren($voucher->getCategory(), $category);
                    if ($isChildren) {
                        $totalAmountCategory = $totalAmountCategory + $item->price;
                    }
                }

                if ($totalAmountCategory > 0) {
                    $this->applyDiscount($voucher, $totalAmountCategory);
                } else {
                    throw new Exception();
                }
            } else {
                $this->applyDiscount($voucher);
            }

            return response('voucher added', 200);
        } catch (Exception $exception) {
            return response('voucher en uso o incorrecto',400);
        }
    }

    private function applyDiscount(Voucher $voucher, $total = null)
    {
        if (!$total) {
            $total = Cart::instance('shopping')->total();
        }

        $this->voucherService->useVoucher($voucher->getCode());
        $discount = $this->voucherService->getDiscountAmount($voucher, $total);

        Cart::instance('discount')->add(
            $voucher->getCode(),
            'Descuento',
            1,
            $discount
        );
    }
}