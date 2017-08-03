<?php
namespace App\Http\Controllers\Frontend;


use Gloudemans\Shoppingcart\Cart;
use Illuminate\Http\Request;

class CartController
{
    public function addToCart(Request $request)
    {
        $code = $request->input('code');
        $price = $request->input('price');
        $product = $request->input('name');
        $quantity = $request->input('quantity');

        if ($quantity > 0) {
            Cart::add($code, $product, $quantity, $price);
        }

        return ['message' => trans('frontend/add_to_cart')];
    }

    public function removeToCart(Request $request)
    {
        $rowId = $request->input('id');

        Cart::remove($rowId);

        return ['message' => trans('frontend/delete_product')];
    }

    public function destroyCart()
    {
        Cart::destroy();

        return ['message' => trans('frontend/cart_deleted')];
    }
}