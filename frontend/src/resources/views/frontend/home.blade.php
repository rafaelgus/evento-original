@extends('frontend.layouts.app')

@section('content')

@include('frontend.partials.slider')

@include('frontend.partials.our-features')

    <div class="content-page">
        <div class="container">
            <div class="row">

                <!-- featured category fashion -->
                <div class="col-md-9">
                    <div class="category-product">
                        <div class="navbar nav-menu">
                            <div class="navbar-collapse">
                                <ul class="nav navbar-nav">
                                    <li>
                                        <div class="new_title text-pantone1">
                                            <h2>{{trans('frontend/home.best_sellers')}}</h2>
                                        </div>
                                    </li>
                                    <input type="hidden" value="{{$i = 0}}">
                                    @foreach($bestSellers as $bestSeller)
                                        @if ($i === 0)
                                            <li class="active"><a data-toggle="tab" href="#{{$bestSeller->getTitle()}}">{{ $bestSeller->getTitle() }}</a> </li>
                                        @else
                                            <li><a data-toggle="tab" href="#tab-1">{{ $bestSeller->getTitle() }}</a> </li>
                                        @endif
                                            <input type="hidden" value="{{$i = $i + 1}}">
                                    @endforeach
                                </ul>
                            </div>
                            <!-- /.navbar-collapse -->

                        </div>
                        <div class="product-bestseller">
                            <div class="product-bestseller-content">
                                <div class="product-bestseller-list">
                                    <div class="tab-container">
                                        <!-- tab product -->
                                        @foreach($bestSellers as $bestSeller)
                                        <div class="tab-panel active" id="{{$bestSeller->getTitle()}}">
                                            <div class="category-products">
                                                <ul class="products-grid">
                                                    @foreach($bestSellerItemCategory[$bestSeller->getCategory()->getName()] as $article)
                                                    <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                                        <div class="item-inner">
                                                            <div class="item-img">
                                                                <div class="item-img-info"> <a class="product-image" title="{{$article->getName()}}" href="{{route('article.detail', ['slug' => $article->getSlug()])}}">
                                                                        <img alt="{{$article->getSlug()}}" src="{{(count($article->getImages()) > 0) ? $article->getImages()->toArray()[0]->getPath(): default_article_image_path() }}" style="max-width: 185px; max-height:207px; min-width: 185px; min-height:207px; ">
                                                                    </a>
                                                                    <div class="box-hover">
                                                                        <ul class="add-to-links">
                                                                            <li><a class="link-quickview" href="quick_view.html"></a> </li>
                                                                            <li><a class="link-wishlist" href="wishlist.html"></a> </li>
                                                                            <li><a class="link-compare" href="compare.html"></a> </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="item-info">
                                                                <div class="info-inner">
                                                                    <div class="item-title"> <a title="{{$article->getName()}}" href="{{route('article.detail', ['slug' => $article->getSlug()])}}"> {{$article->getName()}} </a> </div>
                                                                    <div class="item-content">
                                                                        <div class="rating-item">
                                                                            <div class="ratings">
                                                                                <div class="rating rating-item">
                                                                                    <input type="radio" id="star5" name="rating2" value="5" disabled /><label class="full" for="star5"></label>
                                                                                    <input type="radio" id="star4half" name="rating2" value="4 and a half" disabled/><label class="half" for="star4half"></label>
                                                                                    <input type="radio" id="star4" name="rating2" value="4" checked disabled/><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                                                    <input type="radio" id="star3half" name="rating2" value="3 and a half" disabled/><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                                                    <input type="radio" id="star3" name="rating2" value="3" disabled/><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                                                    <input type="radio" id="star2half" name="rating2" value="2 and a half" disabled/><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                                                    <input type="radio" id="star2" name="rating2" value="2" disabled/><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                                                    <input type="radio" id="star1half" name="rating2" value="1 and a half" disabled/><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                                                    <input type="radio" id="star1" name="rating2" value="1" disabled/><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                                                    <input type="radio" id="starhalf" name="rating2" value="half" disabled/><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                                                                </div>
                                                                                <p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="item-price">
                                                                            <div class="price-box"> <span class="regular-price"> <span class="price"> {{formatted_money($article->getMoneyPrice())}}</span> </span> </div>
                                                                        </div>
                                                                        <div class="action">
                                                                            <button class="button btn-cart" onclick="addItemToCart({{$article->getId()}}, this)" type="button" title="" data-original-title="Add to Cart"><span>{{ strtoupper(trans('frontend/home.buy')) }}</span></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- tab product -->
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- bestsell Slider -->
                    {{--<div class="bestsell-pro">--}}
                        {{--<div class="slider-items-products">--}}
                            {{--<div class="bestsell-block">--}}
                                {{--<div class="block-title">--}}
                                    {{--<h2>Best Sellers</h2>--}}
                                {{--</div>--}}
                                {{--<div id="bestsell-slider" class="product-flexslider hidden-buttons">--}}
                                    {{--<div class="slider-items slider-width-col4 products-grid block-content">--}}
                                        {{--<div class="item">--}}
                                            {{--<div class="item-inner">--}}
                                                {{--<div class="item-img">--}}
                                                    {{--<div class="item-img-info"> <a class="product-image" title="iPhone 6 Plus" href="product_detail.html"> <img alt="iPhone 6 Plus" src="products-images/product1.jpg"> </a>--}}
                                                        {{--<div class="new-label new-top-right">new</div>--}}
                                                        {{--<div class="box-hover">--}}
                                                            {{--<ul class="add-to-links">--}}
                                                                {{--<li><a class="link-quickview" href="quick_view.html"></a> </li>--}}
                                                                {{--<li><a class="link-wishlist" href="wishlist.html"></a> </li>--}}
                                                                {{--<li><a class="link-compare" href="compare.html"></a> </li>--}}
                                                            {{--</ul>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="item-info">--}}
                                                    {{--<div class="info-inner">--}}
                                                        {{--<div class="item-title"> <a title="iPhone 6 Plus" href="product_detail.html"> iPhone 6 Plus </a> </div>--}}
                                                        {{--<div class="rating">--}}
                                                            {{--<div class="ratings">--}}
                                                                {{--<div class="rating-box">--}}
                                                                    {{--<div style="width:80%" class="rating"></div>--}}
                                                                {{--</div>--}}
                                                                {{--<p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="item-content">--}}
                                                            {{--<div class="item-price">--}}
                                                                {{--<div class="price-box"> <span class="regular-price"> <span class="price">€88.00</span> </span> </div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="action">--}}
                                                                {{--<button class="button btn-cart" type="button" title="" data-original-title="Add to Cart"><span>Add to Cart</span> </button>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<!-- Item -->--}}
                                        {{--<div class="item">--}}
                                            {{--<div class="item-inner">--}}
                                                {{--<div class="item-img">--}}
                                                    {{--<div class="item-img-info"> <a class="product-image" title="Noise Smart Watch" href="product_detail.html"> <img alt="Noise Smart Watch" src="products-images/product1.jpg"> </a>--}}
                                                        {{--<div class="box-hover">--}}
                                                            {{--<ul class="add-to-links">--}}
                                                                {{--<li><a class="link-quickview" href="quick_view.html"></a> </li>--}}
                                                                {{--<li><a class="link-wishlist" href="wishlist.html"></a> </li>--}}
                                                                {{--<li><a class="link-compare" href="compare.html"></a> </li>--}}
                                                            {{--</ul>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="item-info">--}}
                                                    {{--<div class="info-inner">--}}
                                                        {{--<div class="item-title"> <a title="Noise Smart Watch" href="product_detail.html"> Noise Smart Watch </a> </div>--}}
                                                        {{--<div class="item-content">--}}
                                                            {{--<div class="rating">--}}
                                                                {{--<div class="ratings">--}}
                                                                    {{--<div class="rating-box">--}}
                                                                        {{--<div style="width:80%" class="rating"></div>--}}
                                                                    {{--</div>--}}
                                                                    {{--<p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="item-price">--}}
                                                                {{--<div class="price-box"> <span class="regular-price"> <span class="price">€325.00</span> </span> </div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="action">--}}
                                                                {{--<button class="button btn-cart" type="button" title="" data-original-title="Add to Cart"><span>Add to Cart</span> </button>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<!-- End Item -->--}}

                                        {{--<!-- Item -->--}}
                                        {{--<div class="item">--}}
                                            {{--<div class="item-inner">--}}
                                                {{--<div class="item-img">--}}
                                                    {{--<div class="item-img-info"> <a class="product-image" title="Morphy Optimo Kettle" href="product_detail.html"> <img alt="Morphy Optimo Kettle" src="products-images/product1.jpg"> </a>--}}
                                                        {{--<div class="box-hover">--}}
                                                            {{--<ul class="add-to-links">--}}
                                                                {{--<li><a class="link-quickview" href="quick_view.html"></a> </li>--}}
                                                                {{--<li><a class="link-wishlist" href="wishlist.html"></a> </li>--}}
                                                                {{--<li><a class="link-compare" href="compare.html"></a> </li>--}}
                                                            {{--</ul>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="item-info">--}}
                                                    {{--<div class="info-inner">--}}
                                                        {{--<div class="item-title"> <a title="Morphy Optimo Kettle" href="product_detail.html"> Morphy Optimo Kettle </a> </div>--}}
                                                        {{--<div class="item-content">--}}
                                                            {{--<div class="rating">--}}
                                                                {{--<div class="ratings">--}}
                                                                    {{--<div class="rating-box">--}}
                                                                        {{--<div style="width:80%" class="rating"></div>--}}
                                                                    {{--</div>--}}
                                                                    {{--<p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="item-price">--}}
                                                                {{--<div class="price-box"> <span class="regular-price"> <span class="price">€245.00</span> </span> </div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="action">--}}
                                                                {{--<button class="button btn-cart" type="button" title="" data-original-title="Add to Cart"><span>Add to Cart</span> </button>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<!-- End Item -->--}}

                                        {{--<div class="item">--}}
                                            {{--<div class="item-inner">--}}
                                                {{--<div class="item-img">--}}
                                                    {{--<div class="item-img-info"> <a class="product-image" title="Omega J8004 Juicer" href="product_detail.html"> <img alt="Omega J8004 Juicer" src="products-images/product1.jpg"> </a>--}}
                                                        {{--<div class="new-label new-top-right">new</div>--}}
                                                        {{--<div class="box-hover">--}}
                                                            {{--<ul class="add-to-links">--}}
                                                                {{--<li><a class="link-quickview" href="quick_view.html"></a> </li>--}}
                                                                {{--<li><a class="link-wishlist" href="wishlist.html"></a> </li>--}}
                                                                {{--<li><a class="link-compare" href="compare.html"></a> </li>--}}
                                                            {{--</ul>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="item-info">--}}
                                                    {{--<div class="info-inner">--}}
                                                        {{--<div class="item-title"> <a title="Omega J8004 Juicer" href="product_detail.html"> Omega J8004 Juicer </a> </div>--}}
                                                        {{--<div class="item-content">--}}
                                                            {{--<div class="rating">--}}
                                                                {{--<div class="ratings">--}}
                                                                    {{--<div class="rating-box">--}}
                                                                        {{--<div style="width:80%" class="rating"></div>--}}
                                                                    {{--</div>--}}
                                                                    {{--<p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="item-price">--}}
                                                                {{--<div class="price-box"> <span class="regular-price"> <span class="price">€225.00</span> </span> </div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="action">--}}
                                                                {{--<button class="button btn-cart" type="button" title="" data-original-title="Add to Cart"><span>Add to Cart</span> </button>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<!-- Item -->--}}
                                        {{--<div class="item">--}}
                                            {{--<div class="item-inner">--}}
                                                {{--<div class="item-img">--}}
                                                    {{--<div class="item-img-info"> <a class="product-image" title="HI114 Dry Iron" href="product_detail.html"> <img alt="HI114 Dry Iron" src="products-images/product1.jpg"> </a>--}}
                                                        {{--<div class="box-hover">--}}
                                                            {{--<ul class="add-to-links">--}}
                                                                {{--<li><a class="link-quickview" href="quick_view.html"></a> </li>--}}
                                                                {{--<li><a class="link-wishlist" href="wishlist.html"></a> </li>--}}
                                                                {{--<li><a class="link-compare" href="compare.html"></a> </li>--}}
                                                            {{--</ul>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="item-info">--}}
                                                    {{--<div class="info-inner">--}}
                                                        {{--<div class="item-title"> <a title="HI114 Dry Iron" href="product_detail.html"> HI114 Dry Iron </a> </div>--}}
                                                        {{--<div class="item-content">--}}
                                                            {{--<div class="rating">--}}
                                                                {{--<div class="ratings">--}}
                                                                    {{--<div class="rating-box">--}}
                                                                        {{--<div style="width:80%" class="rating"></div>--}}
                                                                    {{--</div>--}}
                                                                    {{--<p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="item-price">--}}
                                                                {{--<div class="price-box"> <span class="regular-price"> <span class="price">€115.00</span> </span> </div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="action">--}}
                                                                {{--<button class="button btn-cart" type="button" title="" data-original-title="Add to Cart"><span>Add to Cart</span> </button>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<!-- End Item -->--}}
                                        {{--<div class="item">--}}
                                            {{--<div class="item-inner">--}}
                                                {{--<div class="item-img">--}}
                                                    {{--<div class="item-img-info"> <a class="product-image" title="Food Processor" href="product_detail.html"> <img alt="Food Processor" src="products-images/product1.jpg"> </a>--}}
                                                        {{--<div class="box-hover">--}}
                                                            {{--<ul class="add-to-links">--}}
                                                                {{--<li><a class="link-quickview" href="quick_view.html"></a> </li>--}}
                                                                {{--<li><a class="link-wishlist" href="wishlist.html"></a> </li>--}}
                                                                {{--<li><a class="link-compare" href="compare.html"></a> </li>--}}
                                                            {{--</ul>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="item-info">--}}
                                                    {{--<div class="info-inner">--}}
                                                        {{--<div class="item-title"> <a title="Food Processor" href="product_detail.html"> Food Processor </a> </div>--}}
                                                        {{--<div class="item-content">--}}
                                                            {{--<div class="rating">--}}
                                                                {{--<div class="ratings">--}}
                                                                    {{--<div class="rating-box">--}}
                                                                        {{--<div style="width:80%" class="rating"></div>--}}
                                                                    {{--</div>--}}
                                                                    {{--<p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="item-price">--}}
                                                                {{--<div class="price-box"> <span class="regular-price"> <span class="price">€155.00</span> </span> </div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="action">--}}
                                                                {{--<button class="button btn-cart" type="button" title="" data-original-title="Add to Cart"><span>Add to Cart</span> </button>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<!-- Item -->--}}
                                        {{--<div class="item">--}}
                                            {{--<div class="item-inner">--}}
                                                {{--<div class="item-img">--}}
                                                    {{--<div class="item-img-info"> <a class="product-image" title="iPhone 6 Plus" href="product_detail.html"> <img alt="iPhone 6 Plus" src="products-images/product1.jpg"> </a>--}}
                                                        {{--<div class="box-hover">--}}
                                                            {{--<ul class="add-to-links">--}}
                                                                {{--<li><a class="link-quickview" href="quick_view.html"></a> </li>--}}
                                                                {{--<li><a class="link-wishlist" href="wishlist.html"></a> </li>--}}
                                                                {{--<li><a class="link-compare" href="compare.html"></a> </li>--}}
                                                            {{--</ul>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="item-info">--}}
                                                    {{--<div class="info-inner">--}}
                                                        {{--<div class="item-title"> <a title="iPhone 6 Plus" href="product_detail.html"> iPhone 6 Plus </a> </div>--}}
                                                        {{--<div class="item-content">--}}
                                                            {{--<div class="rating">--}}
                                                                {{--<div class="ratings">--}}
                                                                    {{--<div class="rating-box">--}}
                                                                        {{--<div style="width:80%" class="rating"></div>--}}
                                                                    {{--</div>--}}
                                                                    {{--<p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="item-price">--}}
                                                                {{--<div class="price-box"> <span class="regular-price"> <span class="price">€175.00</span> </span> </div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="action">--}}
                                                                {{--<button class="button btn-cart" type="button" title="" data-original-title="Add to Cart"><span>Add to Cart</span> </button>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<!-- End Item -->--}}

                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    <!--END bestsell Slider -->

                    <!-- Start Featured Slider -->
                    {{--<div class="featured-pro">--}}
                        {{--<div class="slider-items-products">--}}
                            {{--<div class="featured-block">--}}
                                {{--<div class="block-title">--}}
                                    {{--<h2>New Products</h2>--}}
                                {{--</div>--}}
                                {{--<div id="featured-slider" class="product-flexslider hidden-buttons">--}}
                                    {{--<div class="slider-items slider-width-col4 products-grid block-content">--}}
                                        {{--<div class="item">--}}
                                            {{--<div class="item-inner">--}}
                                                {{--<div class="item-img">--}}
                                                    {{--<div class="item-img-info"> <a class="product-image" title="ThinkPad X1 Ultrabook" href="product_detail.html"> <img alt="ThinkPad X1 Ultrabook" src="products-images/product1.jpg"> </a>--}}
                                                        {{--<div class="new-label new-top-right">new</div>--}}
                                                        {{--<div class="box-hover">--}}
                                                            {{--<ul class="add-to-links">--}}
                                                                {{--<li><a class="link-quickview" href="quick_view.html"></a> </li>--}}
                                                                {{--<li><a class="link-wishlist" href="wishlist.html"></a> </li>--}}
                                                                {{--<li><a class="link-compare" href="compare.html"></a> </li>--}}
                                                            {{--</ul>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="item-info">--}}
                                                    {{--<div class="info-inner">--}}
                                                        {{--<div class="item-title"> <a title="ThinkPad X1 Ultrabook" href="product_detail.html"> ThinkPad X1 Ultrabook </a> </div>--}}
                                                        {{--<div class="rating">--}}
                                                            {{--<div class="ratings">--}}
                                                                {{--<div class="rating-box">--}}
                                                                    {{--<div style="width:80%" class="rating"></div>--}}
                                                                {{--</div>--}}
                                                                {{--<p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                        {{--<div class="item-content">--}}
                                                            {{--<div class="item-price">--}}
                                                                {{--<div class="price-box"> <span class="regular-price"> <span class="price">€125.00</span> </span> </div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="action">--}}
                                                                {{--<button class="button btn-cart" type="button" title="" data-original-title="Add to Cart"><span>Add to Cart</span> </button>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<!-- Item -->--}}
                                        {{--<div class="item">--}}
                                            {{--<div class="item-inner">--}}
                                                {{--<div class="item-img">--}}
                                                    {{--<div class="item-img-info"> <a class="product-image" title="Samsung GALAXY Note" href="product_detail.html"> <img alt="Samsung GALAXY Note" src="products-images/product1.jpg"> </a>--}}
                                                        {{--<div class="box-hover">--}}
                                                            {{--<ul class="add-to-links">--}}
                                                                {{--<li><a class="link-quickview" href="quick_view.html"></a> </li>--}}
                                                                {{--<li><a class="link-wishlist" href="wishlist.html"></a> </li>--}}
                                                                {{--<li><a class="link-compare" href="compare.html"></a> </li>--}}
                                                            {{--</ul>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="item-info">--}}
                                                    {{--<div class="info-inner">--}}
                                                        {{--<div class="item-title"> <a title="Samsung GALAXY Note" href="product_detail.html"> Samsung GALAXY Note </a> </div>--}}
                                                        {{--<div class="item-content">--}}
                                                            {{--<div class="rating">--}}
                                                                {{--<div class="ratings">--}}
                                                                    {{--<div class="rating-box">--}}
                                                                        {{--<div style="width:80%" class="rating"></div>--}}
                                                                    {{--</div>--}}
                                                                    {{--<p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="item-price">--}}
                                                                {{--<div class="price-box"> <span class="regular-price"> <span class="price">€235.00</span> </span> </div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="action">--}}
                                                                {{--<button class="button btn-cart" type="button" title="" data-original-title="Add to Cart"><span>Add to Cart</span> </button>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<!-- End Item -->--}}

                                        {{--<!-- Item -->--}}
                                        {{--<div class="item">--}}
                                            {{--<div class="item-inner">--}}
                                                {{--<div class="item-img">--}}
                                                    {{--<div class="item-img-info"> <a class="product-image" title="Epson L360 Printer" href="product_detail.html"> <img alt="Epson L360 Printer" src="products-images/product1.jpg"> </a>--}}
                                                        {{--<div class="box-hover">--}}
                                                            {{--<ul class="add-to-links">--}}
                                                                {{--<li><a class="link-quickview" href="quick_view.html"></a> </li>--}}
                                                                {{--<li><a class="link-wishlist" href="wishlist.html"></a> </li>--}}
                                                                {{--<li><a class="link-compare" href="compare.html"></a> </li>--}}
                                                            {{--</ul>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="item-info">--}}
                                                    {{--<div class="info-inner">--}}
                                                        {{--<div class="item-title"> <a title="Epson L360 Printer" href="product_detail.html"> Epson L360 Printer </a> </div>--}}
                                                        {{--<div class="item-content">--}}
                                                            {{--<div class="rating">--}}
                                                                {{--<div class="ratings">--}}
                                                                    {{--<div class="rating-box">--}}
                                                                        {{--<div style="width:80%" class="rating"></div>--}}
                                                                    {{--</div>--}}
                                                                    {{--<p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="item-price">--}}
                                                                {{--<div class="price-box"> <span class="regular-price"> <span class="price">€325.00</span> </span> </div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="action">--}}
                                                                {{--<button class="button btn-cart" type="button" title="" data-original-title="Add to Cart"><span>Add to Cart</span> </button>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<!-- End Item -->--}}

                                        {{--<div class="item">--}}
                                            {{--<div class="item-inner">--}}
                                                {{--<div class="item-img">--}}
                                                    {{--<div class="item-img-info"> <a class="product-image" title="QX30 Lens Camera" href="product_detail.html"> <img alt="QX30 Lens Camera" src="products-images/product1.jpg"> </a>--}}
                                                        {{--<div class="new-label new-top-right">new</div>--}}
                                                        {{--<div class="box-hover">--}}
                                                            {{--<ul class="add-to-links">--}}
                                                                {{--<li><a class="link-quickview" href="quick_view.html"></a> </li>--}}
                                                                {{--<li><a class="link-wishlist" href="wishlist.html"></a> </li>--}}
                                                                {{--<li><a class="link-compare" href="compare.html"></a> </li>--}}
                                                            {{--</ul>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="item-info">--}}
                                                    {{--<div class="info-inner">--}}
                                                        {{--<div class="item-title"> <a title="QX30 Lens Camera" href="product_detail.html"> QX30 Lens Camera </a> </div>--}}
                                                        {{--<div class="item-content">--}}
                                                            {{--<div class="rating">--}}
                                                                {{--<div class="ratings">--}}
                                                                    {{--<div class="rating-box">--}}
                                                                        {{--<div style="width:80%" class="rating"></div>--}}
                                                                    {{--</div>--}}
                                                                    {{--<p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="item-price">--}}
                                                                {{--<div class="price-box"> <span class="regular-price"> <span class="price">€425.00</span> </span> </div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="action">--}}
                                                                {{--<button class="button btn-cart" type="button" title="" data-original-title="Add to Cart"><span>Add to Cart</span> </button>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        {{--<!-- Item -->--}}
                                        {{--<div class="item">--}}
                                            {{--<div class="item-inner">--}}
                                                {{--<div class="item-img">--}}
                                                    {{--<div class="item-img-info"> <a class="product-image" title="Smart Watch A9" href="product_detail.html"> <img alt="Smart Watch A9" src="products-images/product1.jpg"> </a>--}}
                                                        {{--<div class="box-hover">--}}
                                                            {{--<ul class="add-to-links">--}}
                                                                {{--<li><a class="link-quickview" href="quick_view.html"></a> </li>--}}
                                                                {{--<li><a class="link-wishlist" href="wishlist.html"></a> </li>--}}
                                                                {{--<li><a class="link-compare" href="compare.html"></a> </li>--}}
                                                            {{--</ul>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="item-info">--}}
                                                    {{--<div class="info-inner">--}}
                                                        {{--<div class="item-title"> <a title="Smart Watch A9" href="product_detail.html"> Smart Watch A9 </a> </div>--}}
                                                        {{--<div class="item-content">--}}
                                                            {{--<div class="rating">--}}
                                                                {{--<div class="ratings">--}}
                                                                    {{--<div class="rating-box">--}}
                                                                        {{--<div style="width:80%" class="rating"></div>--}}
                                                                    {{--</div>--}}
                                                                    {{--<p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="item-price">--}}
                                                                {{--<div class="price-box"> <span class="regular-price"> <span class="price">€525.00</span> </span> </div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="action">--}}
                                                                {{--<button class="button btn-cart" type="button" title="" data-original-title="Add to Cart"><span>Add to Cart</span> </button>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<!-- End Item -->--}}
                                        {{--<div class="item">--}}
                                            {{--<div class="item-inner">--}}
                                                {{--<div class="item-img">--}}
                                                    {{--<div class="item-img-info"> <a class="product-image" title="Retis lapen casen" href="product_detail.html"> <img alt="Touch Notebook 500GB HD" src="products-images/product1.jpg"> </a>--}}
                                                        {{--<div class="box-hover">--}}
                                                            {{--<ul class="add-to-links">--}}
                                                                {{--<li><a class="link-quickview" href="quick_view.html"></a> </li>--}}
                                                                {{--<li><a class="link-wishlist" href="wishlist.html"></a> </li>--}}
                                                                {{--<li><a class="link-compare" href="compare.html"></a> </li>--}}
                                                            {{--</ul>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="item-info">--}}
                                                    {{--<div class="info-inner">--}}
                                                        {{--<div class="item-title"> <a title="Retis lapen casen" href="product_detail.html"> Touch Notebook 500GB HD </a> </div>--}}
                                                        {{--<div class="item-content">--}}
                                                            {{--<div class="rating">--}}
                                                                {{--<div class="ratings">--}}
                                                                    {{--<div class="rating-box">--}}
                                                                        {{--<div style="width:80%" class="rating"></div>--}}
                                                                    {{--</div>--}}
                                                                    {{--<p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="item-price">--}}
                                                                {{--<div class="price-box"> <span class="regular-price"> <span class="price">€225.00</span> </span> </div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="action">--}}
                                                                {{--<button class="button btn-cart" type="button" title="" data-original-title="Add to Cart"><span>Add to Cart</span> </button>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<!-- Item -->--}}
                                        {{--<div class="item">--}}
                                            {{--<div class="item-inner">--}}
                                                {{--<div class="item-img">--}}
                                                    {{--<div class="item-img-info"> <a class="product-image" title="Canon Zoom Camera" href="product_detail.html"> <img alt="Canon Zoom Camera" src="products-images/product1.jpg"> </a>--}}
                                                        {{--<div class="box-hover">--}}
                                                            {{--<ul class="add-to-links">--}}
                                                                {{--<li><a class="link-quickview" href="quick_view.html"></a> </li>--}}
                                                                {{--<li><a class="link-wishlist" href="wishlist.html"></a> </li>--}}
                                                                {{--<li><a class="link-compare" href="compare.html"></a> </li>--}}
                                                            {{--</ul>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--<div class="item-info">--}}
                                                    {{--<div class="info-inner">--}}
                                                        {{--<div class="item-title"> <a title="Canon Zoom Camera" href="product_detail.html"> Canon Zoom Camera </a> </div>--}}
                                                        {{--<div class="item-content">--}}
                                                            {{--<div class="rating">--}}
                                                                {{--<div class="ratings">--}}
                                                                    {{--<div class="rating-box">--}}
                                                                        {{--<div style="width:80%" class="rating"></div>--}}
                                                                    {{--</div>--}}
                                                                    {{--<p class="rating-links"> <a href="#">1 Review(s)</a> <span class="separator">|</span> <a href="#">Add Review</a> </p>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="item-price">--}}
                                                                {{--<div class="price-box"> <span class="regular-price"> <span class="price">€185.00</span> </span> </div>--}}
                                                            {{--</div>--}}
                                                            {{--<div class="action">--}}
                                                                {{--<button class="button btn-cart" type="button" title="" data-original-title="Add to Cart"><span>Add to Cart</span> </button>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                        {{--<!-- End Item -->--}}

                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <!-- End Featured Slider -->

                </div>
                <div class="col-md-3">
                    <div class="hot-deal">
                        <ul class="products-grid">
                            <li class="right-space two-height item">
                                <div class="item-inner">
                                    <div class="item-img">
                                        <div class="item-img-info"> <a href="#" title="ThinkPad X1 Ultrabook" class="product-image"> <img src="/images/0004.jpg" alt="ThinkPad X1 Ultrabook"> </a>
                                        </div>
                                    </div>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts_body')

@endsection