<?php
namespace App\Http\Controllers\Frontend;

use EventoOriginal\Core\Services\ArticleService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CartController
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function show()
    {
        $cart = Cart::instance('shopping')->content();
        $discounts = Cart::instance('discount')->content();

        $itemsAndDiscount = [];
        $itemTotal = 0;
        $discountsTotal = 0;

        foreach ($cart as $item) {
            $itemsAndDiscount[] = [
                'id' => $item->rowId,
                'name' => $item->name,
                'qty' => $item->qty,
                'price' => $item->price,
                'image' => $item->options->has('image') ? $item->options->image : '',
                'article' => true
            ];

            $itemTotal = $itemTotal + ($item->price * $item->qty);
        }

        foreach ($discounts as $discount) {
            $itemsAndDiscount[] = [
                'id' => $discount->rowId,
                'name' => $discount->name,
                'qty' => $discount->qty,
                'price' => - $discount->price,
                'image' => $discount->options->has('image') ? $discount->options->image : '',
                'article' => false
            ];

            $discountsTotal = $discountsTotal + $discount->price;
        }

        return view('frontend.shopping_cart')
            ->with('cart', $itemsAndDiscount)
            ->with('discounts', $discountsTotal)
            ->with('total', $itemTotal - $discountsTotal);
    }

    public function addToCart(Request $request)
    {
        $quantity = $request->input('quantity');
        $article = $this
            ->articleService
            ->findOneById(
                $request->input('articleId'),
                    App::getLocale()
            );

        $articleImagesPath = $article->getImages()->toArray()[0]->getPath();

        if ($quantity > 0) {
            Cart::instance('shopping')->add(
                $article->getBarCode(),
                $article->getName(),
                $quantity,
                $article->getPrice(),
                ['image'=> $articleImagesPath]
            );
        }

        return ['message' => trans('frontend/shopping_cart.add_to_cart')];
    }

    public function removeToCart(string $rowId)
    {
        Cart::instance('shopping')->remove($rowId);

        return redirect()->to(trans('frontend/shopping_cart.slug'));
    }

    public function getItemQuantity()
    {
        $quantity = Cart::instance('shopping')->count();

        return ['itemQuantity' => $quantity];
    }

    public function destroyCart()
    {
        Cart::instance('shopping')->destroy();
        Cart::instance('discount')->destroy();

        return redirect()->to(trans('frontend/shopping_cart.slug'));
    }
}