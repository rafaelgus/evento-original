@extends('frontend.layouts.app')

@section('content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul>
                        <li class="home"><a href="index.html" title="Go to Home Page">Home</a> <span>/</span></li>
                        <li class="category1601"><strong>Tazas</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumbs End -->

    <!-- Main Container -->
    <section class="main-container col2-left-layout bounceInUp animated">
        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-sm-push-3">
                    <div class="category-description std">
                        <div class="slider-items-products">
                            <h2 class="page-heading"><span class="page-heading-title">Tazas</span></h2>
                            <p class="category-description">
                            Aqui iria la descripcion de la categoria como por ejemeplo ¿Querés comprar una taza? Aqui
                            econtraras las mejores tazas del mercado, no dudes y llevate las tazas que quieras.
                            </p>
                        </div>
                        <div class="toolbar">
                            <div class="row">
                                <div class="col-lg-4 col-md-5">
                                    <div id="sort-by">
                                        <label class="left">{{ trans('frontend/articles.sort_by') }}: </label>
                                        <ul>
                                            <li><a href="#">{{ trans('frontend/articles.position') }}<span
                                                            class="right-arrow"></span></a>
                                                <ul>
                                                    <li><a href="#">{{ trans('frontend/articles.price_low') }}</a></li>
                                                    <li><a href="#">{{ trans('frontend/articles.price_up') }}</a></li>
                                                    <li><a href="#">{{ trans('frontend/articles.name') }}</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-sm-7 col-md-5">
                                    <div class="pager">
                                        <div class="pages">
                                            <label>{{ trans('frontend/articles.page') }}:</label>
                                            <ul class="pagination">
                                                <li><a href="#">&laquo;</a></li>
                                                <li class="active"><a href="#">1</a></li>
                                                <li><a href="#">2</a></li>
                                                <li><a href="#">3</a></li>
                                                <li><a href="#">4</a></li>
                                                <li><a href="#">5</a></li>
                                                <li><a href="#">&raquo;</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12 col-md-2">
                                    <div id="limiter">
                                        <label>{{ trans('frontend/articles.view') }}: </label>
                                        <ul>
                                            <li><a href="#">09<span class="right-arrow"></span></a>
                                                <ul>
                                                    <li><a href="#">15</a></li>
                                                    <li><a href="#">20</a></li>
                                                    <li><a href="#">30</a></li>
                                                    <li><a href="#">35</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <article class="col-main">
                        <div class="category-products">
                            <ul class="products-grid">
                                <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                    <div class="item-inner">
                                        <div class="item-img">
                                            <div class="item-img-info"><a href="#" title="Food Processor"
                                                                          class="product-image"><img
                                                            src="products-images/product1.jpg" alt="Retis lapen casen"></a>
                                                <div class="new-label new-top-left">New</div>
                                                <div class="box-hover">
                                                    <ul class="add-to-links">
                                                        <li><a class="link-quickview" href="quick_view.html">Quick
                                                                View</a></li>
                                                        <li><a class="link-wishlist" href="wishlist.html">Wishlist</a>
                                                        </li>
                                                        <li><a class="link-compare" href="compare.html">Compare</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-info">
                                            <div class="info-inner">
                                                <div class="item-title"><a title="Food Processor" href="#"> Food
                                                        Processor </a></div>
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
                                                            <p class="old-price"><span class="price-label">Regular Price:</span>
                                                                <span class="price">$100.00 </span></p>
                                                            <p class="special-price"><span class="price-label">Special Price</span>
                                                                <span class="price">$90.00 </span></p>
                                                        </div>
                                                    </div>
                                                    <div class="action">
                                                        <button class="button btn-cart" type="button" title=""
                                                                data-original-title="Comprar">
                                                            <span>Comprar</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                    <div class="item-inner">
                                        <div class="item-img">
                                            <div class="item-img-info"><a href="#" title="Samsung GALAXY Note"
                                                                          class="product-image"><img
                                                            src="products-images/product1.jpg"
                                                            alt="Samsung GALAXY Note"></a>
                                                <div class="box-hover">
                                                    <ul class="add-to-links">
                                                        <li><a class="link-quickview" href="quick_view.html">Quick
                                                                View</a></li>
                                                        <li><a class="link-wishlist" href="wishlist.html">Wishlist</a>
                                                        </li>
                                                        <li><a class="link-compare" href="compare.html">Compare</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-info">
                                            <div class="info-inner">
                                                <div class="item-title"><a href="#" title="Samsung GALAXY Note">Samsung
                                                        GALAXY Note</a></div>
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
                                                        <div class="price-box"><span class="regular-price"><span
                                                                        class="price">$125.00</span> </span></div>
                                                    </div>
                                                    <div class="action">
                                                        <button class="button btn-cart" type="button" title=""
                                                                data-original-title="Comprar">
                                                            <span>Comprar</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                    <div class="item-inner">
                                        <div class="item-img">
                                            <div class="item-img-info"><a href="#" title="Retis lapen casen"
                                                                          class="product-image"><img
                                                            src="products-images/product1.jpg" alt="Retis lapen casen"></a>
                                                <div class="box-hover">
                                                    <ul class="add-to-links">
                                                        <li><a class="link-quickview" href="quick_view.html">Quick
                                                                View</a></li>
                                                        <li><a class="link-wishlist" href="wishlist.html">Wishlist</a>
                                                        </li>
                                                        <li><a class="link-compare" href="compare.html">Compare</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-info">
                                            <div class="info-inner">
                                                <div class="item-title"><a href="#" title="Retis lapen casen">Retis
                                                        lapen casen</a></div>
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
                                                        <div class="price-box"><span class="regular-price"><span
                                                                        class="price">$125.00</span> </span></div>
                                                    </div>
                                                    <div class="action">
                                                        <button class="button btn-cart" type="button" title=""
                                                                data-original-title="Comprar">
                                                            <span>Comprar</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                    <div class="item-inner">
                                        <div class="item-img">
                                            <div class="item-img-info"><a href="#" title="Canvas Tab P290"
                                                                          class="product-image"><img
                                                            src="products-images/product1.jpg"
                                                            alt="Canvas Tab P290"></a>
                                                <div class="new-label new-top-left">New</div>
                                                <div class="box-hover">
                                                    <ul class="add-to-links">
                                                        <li><a class="link-quickview" href="quick_view.html">Quick
                                                                View</a></li>
                                                        <li><a class="link-wishlist" href="wishlist.html">Wishlist</a>
                                                        </li>
                                                        <li><a class="link-compare" href="compare.html">Compare</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-info">
                                            <div class="info-inner">
                                                <div class="item-title"><a title="Canvas Tab P290" href="#"> Canvas Tab
                                                        P290 </a></div>
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
                                                            <p class="old-price"><span class="price-label">Regular Price:</span>
                                                                <span class="price">$100.00 </span></p>
                                                            <p class="special-price"><span class="price-label">Special Price</span>
                                                                <span class="price">$90.00 </span></p>
                                                        </div>
                                                    </div>
                                                    <div class="action">
                                                        <button class="button btn-cart" type="button" title=""
                                                                data-original-title="Comprar">
                                                            <span>Comprar</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                    <div class="item-inner">
                                        <div class="item-img">
                                            <div class="item-img-info"><a href="#" title="ZX110A Stereo Headphone"
                                                                          class="product-image"><img
                                                            src="products-images/product1.jpg"
                                                            alt="ZX110A Stereo Headphone"></a>
                                                <div class="box-hover">
                                                    <ul class="add-to-links">
                                                        <li><a class="link-quickview" href="quick_view.html">Quick
                                                                View</a></li>
                                                        <li><a class="link-wishlist" href="wishlist.html">Wishlist</a>
                                                        </li>
                                                        <li><a class="link-compare" href="compare.html">Compare</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-info">
                                            <div class="info-inner">
                                                <div class="item-title"><a href="#" title="ZX110A Stereo Headphone">ZX110A
                                                        Stereo Headphone</a></div>
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
                                                        <div class="price-box"><span class="regular-price"><span
                                                                        class="price">$125.00</span> </span></div>
                                                    </div>
                                                    <div class="action">
                                                        <button class="button btn-cart" type="button" title=""
                                                                data-original-title="Comprar">
                                                            <span>Comprar</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                    <div class="item-inner">
                                        <div class="item-img">
                                            <div class="item-img-info"><a href="#" title="Pink Sports Watch"
                                                                          class="product-image"><img
                                                            src="products-images/product1.jpg" alt="Pink Sports Watch"></a>
                                                <div class="box-hover">
                                                    <ul class="add-to-links">
                                                        <li><a class="link-quickview" href="quick_view.html">Quick
                                                                View</a></li>
                                                        <li><a class="link-wishlist" href="wishlist.html">Wishlist</a>
                                                        </li>
                                                        <li><a class="link-compare" href="compare.html">Compare</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-info">
                                            <div class="info-inner">
                                                <div class="item-title"><a href="#" title="Pink Sports Watch">Pink
                                                        Sports Watch</a></div>
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
                                                    </div>
                                                    <div class="item-price">
                                                        <div class="price-box"><span class="regular-price"><span
                                                                        class="price">$125.00</span> </span></div>
                                                    </div>
                                                    <div class="action">
                                                        <button class="button btn-cart" type="button" title=""
                                                                data-original-title="Comprar">
                                                            <span>Comprar</span></button>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                    <div class="item-inner">
                                        <div class="item-img">
                                            <div class="item-img-info"><a href="#" title="ThinkPad X1 Ultrabook"
                                                                          class="product-image"><img
                                                            src="products-images/product1.jpg"
                                                            alt="ThinkPad X1 Ultrabook"></a>
                                                <div class="new-label new-top-left">New</div>
                                                <div class="box-hover">
                                                    <ul class="add-to-links">
                                                        <li><a class="link-quickview" href="quick_view.html">Quick
                                                                View</a></li>
                                                        <li><a class="link-wishlist" href="wishlist.html">Wishlist</a>
                                                        </li>
                                                        <li><a class="link-compare" href="compare.html">Compare</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-info">
                                            <div class="info-inner">
                                                <div class="item-title"><a title="ThinkPad X1 Ultrabook" href="#">
                                                        ThinkPad X1 Ultrabook </a></div>
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
                                                            <p class="old-price"><span class="price-label">Regular Price:</span>
                                                                <span class="price">$100.00 </span></p>
                                                            <p class="special-price"><span class="price-label">Special Price</span>
                                                                <span class="price">$90.00 </span></p>
                                                        </div>
                                                    </div>
                                                    <div class="action">
                                                        <button class="button btn-cart" type="button" title=""
                                                                data-original-title="Comprar">
                                                            <span>Comprar</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                    <div class="item-inner">
                                        <div class="item-img">
                                            <div class="item-img-info"><a href="#" title="Yellow Sports Watch"
                                                                          class="product-image"><img
                                                            src="products-images/product1.jpg"
                                                            alt="Yellow Sports Watch"></a>
                                                <div class="box-hover">
                                                    <ul class="add-to-links">
                                                        <li><a class="link-quickview" href="quick_view.html">Quick
                                                                View</a></li>
                                                        <li><a class="link-wishlist" href="wishlist.html">Wishlist</a>
                                                        </li>
                                                        <li><a class="link-compare" href="compare.html">Compare</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-info">
                                            <div class="info-inner">
                                                <div class="item-title"><a href="#" title="Yellow Sports Watch">Yellow
                                                        Sports Watch</a></div>
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
                                                        <div class="price-box"><span class="regular-price"><span
                                                                        class="price">$125.00</span> </span></div>
                                                    </div>
                                                    <div class="action">
                                                        <button class="button btn-cart" type="button" title=""
                                                                data-original-title="Comprar">
                                                            <span>Comprar</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="toolbar">
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    <div id="sort-by">
                                        <label class="left">{{ trans('frontend/articles.sort_by') }}: </label>
                                        <ul>
                                            <li><a href="#">{{ trans('frontend/articles.position') }}<span
                                                            class="right-arrow"></span></a>
                                                <ul>
                                                    <li><a href="#">{{ trans('frontend/articles.price_low') }}</a></li>
                                                    <li><a href="#">{{ trans('frontend/articles.price_up') }}</a></li>
                                                    <li><a href="#">{{ trans('frontend/articles.name') }}</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-sm-7 col-md-5">
                                    <div class="pager">
                                        <div class="pages">
                                            <label>{{ trans('frontend/articles.page') }}:</label>
                                            <ul class="pagination">
                                                <li><a href="#">&laquo;</a></li>
                                                <li class="active"><a href="#">1</a></li>
                                                <li><a href="#">2</a></li>
                                                <li><a href="#">3</a></li>
                                                <li><a href="#">4</a></li>
                                                <li><a href="#">5</a></li>
                                                <li><a href="#">&raquo;</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12 col-md-3">
                                    <div id="limiter">
                                        <label>{{ trans('frontend/articles.view') }}: </label>
                                        <ul>
                                            <li><a href="#">09<span class="right-arrow"></span></a>
                                                <ul>
                                                    <li><a href="#">15</a></li>
                                                    <li><a href="#">20</a></li>
                                                    <li><a href="#">30</a></li>
                                                    <li><a href="#">35</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                    <!--	///*///======    End article  ========= //*/// -->
                </div>
                <div class="col-left sidebar col-sm-3 col-xs-12 col-sm-pull-9">
                    <aside class="col-left sidebar">
                        <div class="side-nav-categories">
                            <div class="block-title">{{ trans('texts.sections.categories.title') }}</div>
                            <!--block-title-->
                            <!-- BEGIN BOX-CATEGORY -->
                            <div class="box-content box-category">
                                <ul>
                                    <li><a  href="grid.html">Tazas de ensueño</a> <span
                                                class="subDropdown minus"></span>
                                        <ul class="level0_415" style="display:block">
                                            <li><a href="grid.html"> Categoria taza ensueño 1 </a> <span class="subDropdown plus"></span>
                                                <ul class="level1" style="display:none">
                                                    <li><a href="grid.html"> SubCategoria taza ensueño </a></li>
                                                    <li><a href="grid.html"> SubCategoria taza ensueño </a></li>
                                                    <li><a href="grid.html"> SubCategoria taza ensueño </a></li>
                                                    <li><a href="grid.html"> SubCategoria taza ensueño</a></li>
                                                    <!--end for-each -->
                                                </ul>
                                                <!--level1-->
                                            </li>
                                            <!--level1-->
                                            <li><a href="grid.html"> Categoria taza ensueño 2 </a> <span
                                                        class="subDropdown plus"></span>
                                                <ul class="level1" >
                                                    <li><a href="grid.html"> SubCategoria taza ensueño </a></li>
                                                    <li><a href="grid.html"> SubCategoria taza ensueño </a></li>
                                                    <li><a href="grid.html"> SubCategoria taza ensueño </a></li>
                                                    <li><a href="grid.html"> SubCategoria taza ensueño </a></li>
                                                    <!--end for-each -->
                                                </ul>
                                                <!--level1-->
                                            </li>
                                        </ul>
                                        <!--level0-->
                                    </li>
                                    <!--level 0-->
                                    <li><a href="grid.html">Tazas originales</a> <span class="subDropdown minus"></span>
                                        <ul class="level0_415" style="display:block" >
                                            <li><a href="grid.html"> Categoria Tazas originales </a> <span class="subDropdown plus"></span>
                                                <ul class="level1">
                                                    <li><a href="grid.html"> SubCategoria Tazas originales </a></li>
                                                    <li><a href="grid.html"> SubCategoria Tazas originales  </a></li>
                                                    <li><a href="grid.html"> SubCategoria Tazas originales  </a></li>
                                                    <!--end for-each -->
                                                </ul>
                                                <!--level1-->
                                            </li>
                                        </ul>
                                        <!--level0-->
                                    </li>
                                </ul>
                            </div>
                            <!--box-content box-category-->
                        </div>
                        <div class="hot-banner"><img alt="banner" src="images/0004.jpg"></div>
                        <div class="block block-layered-nav">
                            <div class="block-title">{{ trans('frontend/articles.shop_by.title') }}</div>
                            <div class="block-content">
                                <dl id="narrow-by-list">
                                    <dt class="odd">{{ trans('frontend/articles.shop_by.price') }}</dt>
                                    <dd class="odd">
                                        <ol>
                                            <li><a href="#"><span class="price">$0.00</span> - <span class="price">$99.99</span></a>
                                                (4)
                                            </li>
                                            <li><a href="#"><span class="price">Más de $100.00</span> </a> (6)</li>
                                        </ol>
                                    </dd>
                                    <dt class="even">{{ trans('frontend/articles.shop_by.brand') }}</dt>
                                    <dd class="even">
                                        <ol>
                                            <li><a href="#">TheBrand</a> (9)</li>
                                            <li><a href="#">Company</a> (4)</li>
                                            <li><a href="#">LogoFashion</a> (1)</li>
                                        </ol>
                                    </dd>
                                    <dt class="odd">{{ trans('frontend/articles.shop_by.color') }}</dt>
                                    <dd class="odd">
                                        <ol>
                                            <li><a href="#">Verde</a> (1)</li>
                                            <li><a href="#">Blanco</a> (5)</li>
                                            <li><a href="#">Negro</a> (5)</li>
                                            <li><a href="#">Gris</a> (4)</li>
                                            <li><a href="#">Gris oscuro</a> (3)</li>
                                            <li><a href="#">Azul</a> (1)</li>
                                        </ol>
                                    </dd>
                                    <dt class="last even">{{ trans('frontend/articles.shop_by.licence') }}</dt>
                                    <dd class="last even">
                                        <ol>
                                            <li><a href="#">Mickey Mouse</a> (6)</li>
                                            <li><a href="#">Superman</a> (6)</li>
                                        </ol>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <div class="block block-cart">
                            <div class="block-title ">{{ trans('frontend/articles.my_cart.title') }}</div>
                            <div class="block-content">
                                <div class="summary">
                                    <p class="amount">{{ trans('frontend/articles.my_cart.there_are') }} <a href="shopping_cart.html">{{ trans_choice('frontend/articles.my_cart.articles', ['quantity' => 1]) }}</a> {{ trans('frontend/articles.my_cart.in_your_cart') }}.
                                    </p>
                                    <p class="subtotal"><span class="label">{{ trans('frontend/articles.my_cart.subtotal') }}</span> <span class="price">$42.99</span>
                                    </p>
                                </div>
                                <div class="ajax-checkout">
                                    <button class="button button-checkout" title="Submit" type="submit">
                                        <span>{{ trans('frontend/articles.my_cart.checkout') }}</span></button>
                                </div>
                                <p class="block-subtitle">{{ trans('frontend/articles.my_cart.recently_added') }} </p>
                                <ul>
                                    <li class="item"><a href="shopping_cart.html" title="iPhone 6 Plus"
                                                        class="product-image"><img src="products-images/product1.jpg"
                                                                                   alt="iPhone 6 Plus"></a>
                                        <div class="product-details">
                                            <div class="access"><a href="shopping_cart.html" title="Remove This Item"
                                                                   class="btn-remove1"> <span class="icon"></span>
                                                    Remove </a></div>
                                            <strong>1</strong> x <span class="price">$19.99</span>
                                            <p class="product-name"><a href="shopping_cart.html">Caramelos azules</a></p>
                                        </div>
                                    </li>
                                    <li class="item last"><a href="shopping_cart.html" title="ThinkPad X1 Ultrabook"
                                                             class="product-image"><img
                                                    src="products-images/product1.jpg" alt="ThinkPad X1 Ultrabook"></a>
                                        <div class="product-details">
                                            <div class="access"><a href="shopping_cart.html" title="Remove This Item"
                                                                   class="btn-remove1"> <span class="icon"></span>
                                                    Remove </a></div>
                                            <strong>1</strong> x <span class="price">$8.00</span>
                                            <p class="product-name"><a href="shopping_cart.html"> Taza de bebé </a></p>

                                            <!--access clearfix-->
                                        </div>
                                    </li>
                                    <li class="item last"><a href="shopping_cart.html" title="Smart Watch A9"
                                                             class="product-image"><img
                                                    src="products-images/product1.jpg" alt="Smart Watch A9"></a>
                                        <div class="product-details">
                                            <div class="access"><a href="shopping_cart.html" title="Remove This Item"
                                                                   class="btn-remove1"> <span class="icon"></span>
                                                    Remove </a></div>
                                            <strong>1</strong> x <span class="price">$15.00</span>
                                            <p class="product-name"><a href="shopping_cart.html"> Ositos  de gominola </a>
                                            </p>

                                            <!--access clearfix-->
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="block block-list block-viewed">
                            <div class="block-title"> {{ trans('frontend/articles.recently_viewed') }}</div>
                            <div class="block-content">
                                <ol id="recently-viewed-items">
                                    <li class="item odd">
                                        <p class="product-name"><a href="#"> Ositos de Gominola </a></p>
                                    </li>
                                    <li class="item even">
                                        <p class="product-name"><a href="#"> Taza personalizada </a></p>
                                    </li>
                                    <li class="item last odd">
                                        <p class="product-name"><a href="#"> Caramelos gomita </a></p>
                                    </li>
                                </ol>
                            </div>
                        </div>

                        <div class="block block-tags">
                            <div class="block-title"> {{ trans('frontend/articles.popular_tags') }}</div>
                            <div class="block-content">
                                <ul class="tags-list">
                                    <li><a href="#" style="font-size:98.3333333333%;">Camera</a></li>
                                    <li><a href="#" style="font-size:86.6666666667%;">Notebook</a></li>
                                    <li><a href="#" style="font-size:145%;">NOTE</a></li>
                                    <li><a href="#" style="font-size:75%;">juicer</a></li>
                                    <li><a href="#" style="font-size:110%;">Watch</a></li>
                                    <li><a href="#" style="font-size:86.6666666667%;">Iron</a></li>
                                    <li><a href="#" style="font-size:110%;">printer</a></li>
                                    <li><a href="#" style="font-size:86.6666666667%;">scanner</a></li>
                                    <li><a href="#" style="font-size:86.6666666667%;">iphone</a></li>
                                    <li><a href="#" style="font-size:86.6666666667%;">dualsim</a></li>
                                    <li><a href="#" style="font-size:86.6666666667%;">slim</a></li>
                                    <li><a href="#" style="font-size:86.6666666667%;">HD</a></li>
                                    <li><a href="#" style="font-size:75%;">laptop</a></li>
                                    <li><a href="#" style="font-size:75%;">mobile</a></li>
                                    <li><a href="#" style="font-size:75%;">nice</a></li>
                                    <li><a href="#" style="font-size:86.6666666667%;">phone</a></li>
                                    <li><a href="#" style="font-size:98.3333333333%;">red</a></li>
                                    <li><a href="#" style="font-size:86.6666666667%;">tight</a></li>
                                    <li><a href="#" style="font-size:75%;">trendy</a></li>
                                    <li><a href="#" style="font-size:86.6666666667%;">young</a></li>
                                </ul>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
    <!-- Main Container End -->
@endsection