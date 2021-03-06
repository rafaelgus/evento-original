@extends('frontend.layouts.app')

@section('content')
    <div class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <section class="col-sm-9 wow bounceInUp animated">
                    <div class="col-main">
                        <div class="my-account">
                            <div class="page-title">
                                <h2>{{ trans('frontend/my_wishlist.title') }}</h2>
                            </div>
                            <div class="my-wishlist">
                                <div class="table-responsive">
                                    <form method="post" action="#/wishlist/index/update/wishlist_id/1/" id="wishlist-view-form">
                                        <fieldset>
                                            <input type="hidden" value="ROBdJO5tIbODPZHZ" name="form_key">
                                            <table id="wishlist-table" class="clean-table linearize-table data-table">
                                                <thead>
                                                <tr class="first last">
                                                    <th class="customer-wishlist-item-image"></th>
                                                    <th class="customer-wishlist-item-info"></th>
                                                    <th class="customer-wishlist-item-quantity">{{ trans('frontend/my_wishlist.quantity') }}</th>
                                                    <th class="customer-wishlist-item-price">{{ trans('frontend/my_wishlist.price') }}</th>
                                                    <th class="customer-wishlist-item-cart"></th>
                                                    <th class="customer-wishlist-item-remove"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr id="item_31" class="first odd">
                                                    <td class="wishlist-cell0 customer-wishlist-item-image"><a title="ThinkPad Ultrabook" href="#/" class="product-image"> <img width="150" alt="ThinkPad X1 Ultrabook" src="products-images/product1.jpg"> </a></td>
                                                    <td class="wishlist-cell1 customer-wishlist-item-info"><h3 class="product-name"><a title="ThinkPad Ultrabook" href="#">ThinkPad X1 Ultrabook</a></h3>
                                                        <div class="description std">
                                                            <div class="inner">Sea congue inciderint in. Augue contentiones id cum, nec alii argumentum</div>
                                                        </div>
                                                        </td>
                                                    <td data-rwd-label="Quantity" class="wishlist-cell2 customer-wishlist-item-quantity"><div class="cart-cell">
                                                            <div class="add-to-cart-alt">
                                                                <input type="text" value="1" name="qty[31]" class="input-text qty validate-not-negative-number" pattern="\d*">
                                                            </div>
                                                        </div></td>
                                                    <td data-rwd-label="Price" class="wishlist-cell3 customer-wishlist-item-price"><div class="cart-cell">
                                                            <div class="price-box"> <span id="product-price-39" class="regular-price"> <span class="price">$99.00</span> </span> </div>
                                                        </div></td>
                                                    <td class="wishlist-cell4 customer-wishlist-item-cart"><div class="cart-cell">
                                                            <button class="button btn-cart" onclick="addWItemToCart(31);" title="Add to Cart" type="button"><span><span>Add to Cart</span></span></button>
                                                        </div></td>
                                                    <td class="wishlist-cell5 customer-wishlist-item-remove last"><a class="remove-item" title="Clear Cart"  href="#"><span><span></span></span></a></td>
                                                </tr>
                                                <tr id="item_33" class="odd">
                                                    <td class="wishlist-cell0 customer-wishlist-item-image"><a title="Softwear Women's Designer" href="#" class="product-image"> <img width="150" alt="Softwear Women's Designer" src="products-images/product1.jpg"> </a></td>
                                                    <td class="wishlist-cell1 customer-wishlist-item-info"><h3 class="product-name"><a title="Samsung GALAXY Note" href="#">Samsung GALAXY Note</a></h3>
                                                        <div class="description std">
                                                            <div class="inner">Sea congue inciderint in. Augue contentiones id cum, nec alii argumentum</div>
                                                        </div>
                                                        </td>
                                                    <td data-rwd-label="Quantity" class="wishlist-cell2 customer-wishlist-item-quantity"><div class="cart-cell">
                                                            <div class="add-to-cart-alt">
                                                                <input type="text" value="1" name="qty[31]" class="input-text qty validate-not-negative-number" pattern="\d*">
                                                            </div>
                                                        </div></td>
                                                    <td data-rwd-label="Price" class="wishlist-cell3 customer-wishlist-item-price"><div class="cart-cell">
                                                            <div class="price-box"> <span id="product-price-39" class="regular-price"> <span class="price">$99.00</span> </span> </div>
                                                        </div></td>
                                                    <td class="wishlist-cell4 customer-wishlist-item-cart"><div class="cart-cell">
                                                            <button class="button btn-cart" onclick="addWItemToCart(31);" title="Add to Cart" type="button"><span><span>Add to Cart</span></span></button>
                                                        </div></td>
                                                    <td class="wishlist-cell5 customer-wishlist-item-remove last"><a class="remove-item" title="Clear Cart"  href="#"><span><span></span></span></a></td>
                                                </tr>
                                                <tr id="item_32" class="last even">
                                                    <td class="wishlist-cell0 customer-wishlist-item-image"><a title="Noise Smart Watch " href="#" class="product-image"> <img width="150" alt=" Noise Smart Watch " src="products-images/product1.jpg"> </a></td>
                                                    <td class="wishlist-cell1 customer-wishlist-item-info"><h3 class="product-name"><a title="Slim Fit Casual Shirt" href="#"> Noise Smart Watch</a></h3>
                                                        <div class="description std">
                                                            <div class="inner">Sea congue inciderint in. Augue contentiones id cum, nec alii argumentum</div>
                                                        </div>
                                                        </td>
                                                    <td data-rwd-label="Quantity" class="wishlist-cell2 customer-wishlist-item-quantity"><div class="cart-cell">
                                                            <div class="add-to-cart-alt">
                                                                <input type="text" value="1" name="qty[32]" class="input-text qty validate-not-negative-number" pattern="\d*">
                                                            </div>
                                                        </div></td>
                                                    <td data-rwd-label="Price" class="wishlist-cell3 customer-wishlist-item-price"><div class="cart-cell">
                                                            <div class="price-box"> <span id="product-price-2" class="regular-price"> <span class="price">$55.00</span> </span> </div>
                                                        </div></td>
                                                    <td class="wishlist-cell4 customer-wishlist-item-cart"><div class="cart-cell">
                                                            <button class="button btn-cart" onclick="addWItemToCart(32);" title="Add to Cart" type="button"><span><span>Add to Cart</span></span></button>
                                                        </div></td>
                                                    <td class="wishlist-cell5 customer-wishlist-item-remove last"><a class="remove-item" title="Clear Cart"  href="#"><span><span></span></span></a></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <div class="buttons-set buttons-set2">
                                                <button class="button btn-add" onclick="addAllWItemsToCart()" title="Add All to Cart" type="button"><span>{{ trans('frontend/my_wishlist.add_all_to_cart')}}</span></button>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div></div>
                </section>

                @include('frontend.partials.my_account_sidebar')
            </div>
        </div>
    </div>
@endsection

@section('scripts_body')
    <script>
        $(document).ready(function() {
            $('#my_wishlist').addClass("current");
        });
    </script>
@endsection