@extends('frontend.layouts.app')

@section('content')
    <!-- Main Container -->
    <section class="main-container col1-layout">
        <div class="main container">
            <div class="col-main">
                <div class="cart wow bounceInUp animated">
                    <div class="page-title">
                        <h2>{{ trans('frontend/shopping_cart.your_cart') }}</h2>
                    </div>
                    <div class="table-responsive">
                        <form method="post" action="#updatePost/">
                            <input type="hidden" value="Vwww7itR3zQFe86m" name="form_key">
                            <fieldset>
                                <table class="data-table cart-table" id="shopping-cart-table">
                                    <colgroup>
                                        <col width="1">
                                        <col>
                                        <col width="1">
                                        <col width="1">
                                        <col width="1">
                                        <col width="1">
                                        <col width="1">
                                    </colgroup>
                                    <thead>
                                    <tr class="first last">
                                        <th rowspan="1">&nbsp;</th>
                                        <th rowspan="1"><span class="nobr">{{ trans('frontend/shopping_cart.product') }}</span></th>
                                        <th rowspan="1"></th>
                                        <th colspan="1" class="a-center"><span class="nobr">{{ trans('frontend/shopping_cart.unit_price') }}</span></th>
                                        <th class="a-center" rowspan="1">{{ trans('frontend/shopping_cart.quantity') }}</th>
                                        <th colspan="1" class="a-center">Subtotal</th>
                                        <th class="a-center" rowspan="1">&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr class="first last">
                                        <td class="a-right last" colspan="50"><button onClick="setLocation('#')" class="button btn-continue" title="Continue Shopping" type="button"><span>{{ trans('frontend/shopping_cart.continue_shopping') }}</span></button>
                                            <a id="empty_cart_button" class="button btn-empty" title="Clear Cart" href="/destroyCart" name="update_cart_action"><span>{{ trans('frontend/shopping_cart.clear_cart') }}</span></a></td>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($cart as $item)
                                    <tr class="first odd">
                                        <td class="image"><a class="product-image" title="{{$item['name']}}" href=""><img width="75" alt="{{$item['name']}}" src="{{ (!empty($item['image']) ? $item['image'] : '/images/logo.png')}}"></a></td>
                                        <td><h2 class="product-name"> <a href="#">{{$item['name']}}</a> </h2></td>
                                        <td class="a-center"><a title="Edit item parameters" class="edit-bnt" href="#configure/id/15945/"></a></td>
                                        <td class="a-right"><span class="cart-price"><span class="price">{{($item['price']/100)}} €</span> </span></td>
                                        <td class="a-center movewishlist"><input maxlength="12" class="input-text qty" title="Qty" size="4" value="{{$item['qty']}}" onchange="changeQuantity('{{$item['id']}}')" name="cart[15945][qty]" id="productQty" type="number"></td>
                                        <td class="a-right movewishlist"><span class="cart-price"> <span class="price">{{formatted_money(new \Money\Money(($item['price'] * $item['qty']), new \Money\Currency($item['currency'])))}}</span></span></td>
                                        @if($item['article'])<td class="a-center last"><a class="button remove-item" title="Remove item" href="/removeToCart/{{$item['id']}}"><span><span>Remove item</span></span></a></td>@endif
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </fieldset>
                        </form>
                    </div>
                    <!-- BEGIN CART COLLATERALS -->
                    <div class="cart-collaterals row">
                        <div class="col-sm-6">
                            <div class="discount">
                                <h3>{{ trans('frontend/shopping_cart.discount_codes') }}</h3>
                                <form method="post" action="#couponPost/" id="discount-coupon-form">
                                    <label for="coupon_code">{{ trans('frontend/shopping_cart.enter_discount_code') }}</label>
                                    <input type="hidden" value="0" id="remove-coupone" name="remove">
                                    <input type="text" value="" name="coupon_code" id="coupon_code" class="input-text fullwidth">
                                    <button value="Apply Coupon" onClick="useVoucher()" class="button coupon " title="Apply Coupon" type="button"><span>{{ trans('frontend/shopping_cart.apply_coupon') }}</span></button>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="totals">
                                <h3>{{ trans('frontend/shopping_cart.total') }}</h3>
                                <div class="inner">
                                    <table class="table shopping-cart-table-total" id="shopping-cart-totals-table">
                                        <colgroup>
                                            <col>
                                            <col width="1">
                                        </colgroup>
                                        <tbody>
                                        <tr>
                                            <td colspan="1" class="a-left" style=""> Subtotal </td>
                                                <td class="a-right" style=""><span class="price">{{ formatted_money($total) }}</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="1" class="a-left" style=""> {{ trans('frontend/shopping_cart.discount') }} </td>
                                            <td class="a-right" style=""><span class="price"> - {{  formatted_money($discounts)  }}</span></td>
                                        </tr>
                                        </tbody>

                                        <tfoot>
                                        <tr>
                                            <td colspan="1" class="a-left" style=""><strong>{{ trans('frontend/shopping_cart.total') }}</strong></td>
                                            <td class="a-right" style=""><strong><span class="price">{{ formatted_money($total)}}</span></strong></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    <ul class="checkout">
                                        <li>
                                            @if($proceedCheckout)
                                            <button class="button btn-proceed-checkout" onclick="checkout()" title="{{ trans('frontend/shopping_cart.proceed_to_checkout') }}" type="button"><span>{{ trans('frontend/shopping_cart.proceed_to_checkout') }}</span></button>
                                            @endif
                                        </li>
                                        <br>
                                    </ul>
                                </div>
                                <!--inner-->
                            </div>

                        </div>
                    </div>

                    <!--cart-collaterals-->

                </div>
                <div class="crosssel bounceInUp animated">
                    <div class="new_title">
                        <h2><strong>{{ trans('frontend/shopping_cart.recommended_for_you') }}</strong> </h2>
                    </div>


                    <div class="category-products">
                        <ul class="products-grid">
                            <li class="item col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                <div class="item-inner">
                                    <div class="item-img">
                                        <div class="item-img-info">
                                            <a class="product-image" title="Retis lapen casen" href="product_detail.html"> <img alt="Retis lapen casen" src="products-images/product1.jpg"> </a>
                                            <div class="box-hover">
                                                <ul class="add-to-links">
                                                    <li><a class="link-quickview" href="quick_view.html">Quick View</a>
                                                    </li>
                                                    <li><a class="link-wishlist" href="wishlist.html">Wishlist</a>
                                                    </li>
                                                    <li><a class="link-compare" href="compare.html">Compare</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-info">
                                        <div class="info-inner">
                                            <div class="item-title"> <a title="Retis lapen casen" href="product_detail.html"> Retis lapen casen </a> </div>
                                            <div class="item-content">
                                                <div class="rating-item">
                                                    <div class="ratings">
                                                        <fieldset class="rating">
                                                            <input type="radio" id="star5" name="rating" value="5" checked /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                            <input type="radio" id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                                            <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                            <input type="radio" id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                            <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                            <input type="radio" id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                            <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                            <input type="radio" id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                            <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                            <input type="radio" id="starhalf" name="rating" value="half"/><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                                        </fieldset>
                                                        <p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>
                                                    </div>
                                                </div>
                                                <div class="item-price">
                                                    <div class="price-box"> <span class="regular-price"> <span class="price">$155.00</span> </span>
                                                    </div>
                                                </div>
                                                <div class="action">
                                                    <button class="button btn-cart" type="button" title="" data-original-title="Comprar"><span>Comprar</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="item col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                <div class="item-inner">
                                    <div class="item-img">
                                        <div class="item-img-info">
                                            <a class="product-image" title="Retis lapen casen" href="product_detail.html"> <img alt="Retis lapen casen" src="products-images/product1.jpg"> </a>
                                            <div class="box-hover">
                                                <ul class="add-to-links">
                                                    <li><a class="link-quickview" href="quick_view.html">Quick View</a>
                                                    </li>
                                                    <li><a class="link-wishlist" href="wishlist.html">Wishlist</a>
                                                    </li>
                                                    <li><a class="link-compare" href="compare.html">Compare</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-info">
                                        <div class="info-inner">
                                            <div class="item-title"> <a title="Retis lapen casen" href="product_detail.html"> Retis lapen casen </a> </div>
                                            <div class="item-content">
                                                <div class="rating-item">
                                                    <div class="ratings">
                                                        <fieldset class="rating">
                                                            <input type="radio" id="star5" name="rating" value="5" checked /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                            <input type="radio" id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                                            <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                            <input type="radio" id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                            <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                            <input type="radio" id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                            <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                            <input type="radio" id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                            <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                            <input type="radio" id="starhalf" name="rating" value="half"/><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                                        </fieldset>
                                                        <p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>
                                                    </div>
                                                </div>
                                                <div class="item-price">
                                                    <div class="price-box"> <span class="regular-price"> <span class="price">$155.00</span> </span>
                                                    </div>
                                                </div>
                                                <div class="action">
                                                    <button class="button btn-cart" type="button" title="" data-original-title="Comprar"><span>Comprar</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="item col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                <div class="item-inner">
                                    <div class="item-img">
                                        <div class="item-img-info">
                                            <a class="product-image" title="Retis lapen casen" href="product_detail.html"> <img alt="Retis lapen casen" src="products-images/product1.jpg"> </a>
                                            <div class="box-hover">
                                                <ul class="add-to-links">
                                                    <li><a class="link-quickview" href="quick_view.html">Quick View</a>
                                                    </li>
                                                    <li><a class="link-wishlist" href="wishlist.html">Wishlist</a>
                                                    </li>
                                                    <li><a class="link-compare" href="compare.html">Compare</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-info">
                                        <div class="info-inner">
                                            <div class="item-title"> <a title="Retis lapen casen" href="product_detail.html"> Retis lapen casen </a> </div>
                                            <div class="item-content">
                                                <div class="rating-item">
                                                    <div class="ratings">
                                                        <fieldset class="rating">
                                                            <input type="radio" id="star5" name="rating" value="5" checked /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                            <input type="radio" id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                                            <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                            <input type="radio" id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                            <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                            <input type="radio" id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                            <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                            <input type="radio" id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                            <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                            <input type="radio" id="starhalf" name="rating" value="half"/><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                                        </fieldset>
                                                        <p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>
                                                    </div>
                                                </div>
                                                <div class="item-price">
                                                    <div class="price-box"> <span class="regular-price"> <span class="price">$155.00</span> </span>
                                                    </div>
                                                </div>
                                                <div class="action">
                                                    <button class="button btn-cart" type="button" title="" data-original-title="Comprar"><span>Comprar</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="item col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                <div class="item-inner">
                                    <div class="item-img">
                                        <div class="item-img-info">
                                            <a class="product-image" title="Retis lapen casen" href="product_detail.html"> <img alt="Retis lapen casen" src="products-images/product1.jpg"> </a>
                                            <div class="box-hover">
                                                <ul class="add-to-links">
                                                    <li><a class="link-quickview" href="quick_view.html">Quick View</a>
                                                    </li>
                                                    <li><a class="link-wishlist" href="wishlist.html">Wishlist</a>
                                                    </li>
                                                    <li><a class="link-compare" href="compare.html">Compare</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-info">
                                        <div class="info-inner">
                                            <div class="item-title"> <a title="Retis lapen casen" href="product_detail.html"> Retis lapen casen </a> </div>
                                            <div class="item-content">
                                                <div class="rating-item">
                                                    <div class="ratings">
                                                        <fieldset class="rating">
                                                            <input type="radio" id="star5" name="rating" value="5" checked /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                            <input type="radio" id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                                            <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                            <input type="radio" id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                            <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                            <input type="radio" id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                            <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                            <input type="radio" id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                            <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                            <input type="radio" id="starhalf" name="rating" value="half"/><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                                        </fieldset>
                                                        <p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>
                                                    </div>
                                                </div>
                                                <div class="item-price">
                                                    <div class="price-box"> <span class="regular-price"> <span class="price">$225.00</span> </span>
                                                    </div>
                                                </div>
                                                <div class="action">
                                                    <button class="button btn-cart" type="button" title="" data-original-title="Comprar"><span>Comprar</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="item col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                <div class="item-inner">
                                    <div class="item-img">
                                        <div class="item-img-info">
                                            <a class="product-image" title="Retis lapen casen" href="product_detail.html"> <img alt="Samsung GALAXY Note" src="products-images/product1.jpg"> </a>
                                            <div class="box-hover">
                                                <ul class="add-to-links">
                                                    <li><a class="link-quickview" href="quick_view.html">Quick View</a>
                                                    </li>
                                                    <li><a class="link-wishlist" href="wishlist.html">Wishlist</a>
                                                    </li>
                                                    <li><a class="link-compare" href="compare.html">Compare</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-info">
                                        <div class="info-inner">
                                            <div class="item-title"> <a title="Retis lapen casen" href="product_detail.html"> Samsung GALAXY Note </a> </div>
                                            <div class="item-content">
                                                <div class="rating-item">
                                                    <div class="ratings">
                                                        <fieldset class="rating">
                                                            <input type="radio" id="star5" name="rating" value="5" checked /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                            <input type="radio" id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                                            <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                            <input type="radio" id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                            <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                            <input type="radio" id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                            <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                            <input type="radio" id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                            <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                            <input type="radio" id="starhalf" name="rating" value="half"/><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                                        </fieldset>
                                                        <p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>
                                                    </div>
                                                </div>
                                                <div class="item-price">
                                                    <div class="price-box"> <span class="regular-price"> <span class="price">$99.00</span> </span>
                                                    </div>
                                                </div>
                                                <div class="action">
                                                    <button class="button btn-cart" type="button" title="" data-original-title="Comprar"><span>Comprar</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="item col-lg-2 col-md-2 col-sm-3 col-xs-6">
                                <div class="item-inner">
                                    <div class="item-img">
                                        <div class="item-img-info">
                                            <a class="product-image" title="Epson L360 Printer" href="product_detail.html"> <img alt="Epson L360 Printer" src="products-images/product1.jpg"> </a>
                                            <div class="new-label new-top-left">nuevo</div>
                                            <div class="box-hover">
                                                <ul class="add-to-links">
                                                    <li><a class="link-quickview" href="quick_view.html">Quick View</a>
                                                    </li>
                                                    <li><a class="link-wishlist" href="wishlist.html">Wishlist</a>
                                                    </li>
                                                    <li><a class="link-compare" href="compare.html">Compare</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-info">
                                        <div class="info-inner">
                                            <div class="item-title"> <a title="Retis lapen casen" href="product_detail.html"> Epson L360 Printer </a> </div>
                                            <div class="item-content">
                                                <div class="rating-item">
                                                    <div class="ratings">
                                                        <fieldset class="rating">
                                                            <input type="radio" id="star5" name="rating" value="5" checked /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                            <input type="radio" id="star4half" name="rating" value="4 and a half" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                                            <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                            <input type="radio" id="star3half" name="rating" value="3 and a half" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                            <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                            <input type="radio" id="star2half" name="rating" value="2 and a half" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                            <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                            <input type="radio" id="star1half" name="rating" value="1 and a half" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                            <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                            <input type="radio" id="starhalf" name="rating" value="half"/><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                                        </fieldset>
                                                        <p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>
                                                    </div>
                                                </div>
                                                <div class="item-price">
                                                    <div class="price-box">
                                                        <p class="special-price"> <span class="price-label">Special Price</span> <span class="price"> $156.00 </span> </p>
                                                        <p class="old-price"> <span class="price-label">Regular Price:</span> <span class="price"> $167.00 </span> </p>
                                                    </div>
                                                </div>
                                                <div class="action">
                                                    <button class="button btn-cart" type="button" title="" data-original-title="Comprar"><span>Comprar</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Main Container End -->

@endsection

@section('scripts_body')
    <script type="text/javascript">
        function useVoucher() {
            var code = document.getElementById('coupon_code').value;

            var params = encodeURI('code=' + code);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/discount', true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.onreadystatechange = function () {
                if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    window.location.href = '{{ trans('frontend/shopping_cart.slug') }}'
                }
                if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 400) {
                   alert('Voucher en uso o incorrecto');
                }
            };

            xhr.send(params);
        }
        function checkout() {
            window.location.href = '/checkout/billing';
        }

        function changeQuantity(rowId) {
            var quantity = document.getElementById('productQty').value;

            var params = encodeURI('qty=' + quantity + '&rowId=' + rowId);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/updateQty', true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

            xhr.onreadystatechange = function () {
               window.location.href = '/{{ trans('frontend/shopping_cart.slug') }}';
            };
            xhr.send(params);
        }
    </script>
@endsection