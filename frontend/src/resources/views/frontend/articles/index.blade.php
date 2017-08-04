@extends('frontend.layouts.app')

@section('scripts_header')
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/css/bootstrap-slider.min.css">
@stop

@section('content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul>
                        <li class="home"><a href="index.html" title="Go to Home Page">Home</a> <span>/</span></li>
                        <li class="category1601"><strong>{{ $category->getName() }}</strong></li>
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
                            <h2 class="page-heading"><span class="page-heading-title">{{ $category->getName() }}</span>
                            </h2>
                            <p class="category-description">
                                {{ $category->getDescription() }}
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
                                @foreach($articles as $article)
                                    <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                        <div class="item-inner">
                                            <div class="item-img">
                                                <div class="item-img-info"><a href="{{ "/articulo/" . $article->getSlug() }}" title="Food Processor"
                                                                              class="product-image"><img
                                                                src="products-images/product1.jpg"
                                                                alt="Retis lapen casen"></a>
                                                    <div class="new-label new-top-left">New</div>
                                                    <div class="box-hover">
                                                        <ul class="add-to-links">
                                                            <li><a class="link-quickview" href="quick_view.html">Quick
                                                                    View</a></li>
                                                            <li><a class="link-wishlist"
                                                                   href="wishlist.html">Wishlist</a>
                                                            </li>
                                                            <li><a class="link-compare" href="compare.html">Compare</a>
                                                            </li>
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
                                                                    <input type="radio" id="star5" name="rating"
                                                                           value="5"
                                                                           checked/><label class="full" for="star5"
                                                                                           title="Awesome - 5 stars"></label>
                                                                    <input type="radio" id="star4half" name="rating"
                                                                           value="4 and a half"/><label class="half"
                                                                                                        for="star4half"
                                                                                                        title="Pretty good - 4.5 stars"></label>
                                                                    <input type="radio" id="star4" name="rating"
                                                                           value="4"/><label
                                                                            class="full" for="star4"
                                                                            title="Pretty good - 4 stars"></label>
                                                                    <input type="radio" id="star3half" name="rating"
                                                                           value="3 and a half"/><label class="half"
                                                                                                        for="star3half"
                                                                                                        title="Meh - 3.5 stars"></label>
                                                                    <input type="radio" id="star3" name="rating"
                                                                           value="3"/><label
                                                                            class="full" for="star3"
                                                                            title="Meh - 3 stars"></label>
                                                                    <input type="radio" id="star2half" name="rating"
                                                                           value="2 and a half"/><label class="half"
                                                                                                        for="star2half"
                                                                                                        title="Kinda bad - 2.5 stars"></label>
                                                                    <input type="radio" id="star2" name="rating"
                                                                           value="2"/><label
                                                                            class="full" for="star2"
                                                                            title="Kinda bad - 2 stars"></label>
                                                                    <input type="radio" id="star1half" name="rating"
                                                                           value="1 and a half"/><label class="half"
                                                                                                        for="star1half"
                                                                                                        title="Meh - 1.5 stars"></label>
                                                                    <input type="radio" id="star1" name="rating"
                                                                           value="1"/><label
                                                                            class="full" for="star1"
                                                                            title="Sucks big time - 1 star"></label>
                                                                    <input type="radio" id="starhalf" name="rating"
                                                                           value="half"/><label class="half"
                                                                                                for="starhalf"
                                                                                                title="Sucks big time - 0.5 stars"></label>
                                                                </fieldset>
                                                                <p class="rating-links"><a href="#">1 Review(s)</a>
                                                                    <span
                                                                            class="separator">|</span> <a href="#">Add
                                                                        Review</a></p>
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
                                @endforeach
                            </ul>
                        </div>
                    </article>
                    <!--	///*///======    End article  ========= //*/// -->
                </div>
                <div class="col-left sidebar col-sm-3 col-xs-12 col-sm-pull-9">
                    <aside class="col-left sidebar">
                        <div class="block block-layered-nav">
                            <div class="block-title">{{ trans('frontend/articles.shop_by.title') }}</div>
                            <div class="block-content">
                                <dl id="narrow-by-list">

                                    @if(count($category->getChildren()) > 0)
                                        <dt class="even">{{ trans('frontend/articles.shop_by.brand') }}</dt>
                                        <dd class="even">
                                            <ol>
                                                @foreach($category->getChildren() as $category)
                                                    <li>
                                                        <input type="checkbox" name="category-filter" class=""
                                                               value="{{ $category->getSlug() }}"> {{ $category->getName() }}
                                                    </li>
                                                @endforeach()
                                            </ol>
                                        </dd>
                                    @endif

                                    <dt class="odd">{{ trans('frontend/articles.shop_by.price') }}</dt>
                                    <dd class="odd">
                                        <p>
                                            <label for="price-filter-value">{{ trans('frontend/articles.range') }}
                                                : </label>
                                            <input type="text" value="€0,00-€1000" id="price-filter-value" readonly
                                                   style="border:0; color:#f6931f; font-weight:bold;">
                                        </p>
                                        <input id="price_filter" type="text" class="span2" value="" data-slider-min="10"
                                               data-slider-max="1000" data-slider-step="5"
                                               data-slider-value="[0,1000]"/>
                                    </dd>

                                    @if(count($brands) > 0)
                                        <dt class="even">{{ trans('frontend/articles.shop_by.brand') }}</dt>
                                        <dd class="even">
                                            <ol>
                                                @foreach($brands as $brand)
                                                    <li>
                                                        <input type="checkbox" name="brand-filter" class=""
                                                               value="{{ $brand->getId() }}"> {{ $brand->getName() }}
                                                    </li>
                                                @endforeach()
                                            </ol>
                                        </dd>
                                    @endif

                                    @if(count($colors) > 0)
                                        <dt class="odd">{{ trans('frontend/articles.shop_by.color') }}</dt>
                                        <dd class="odd">
                                            <ol>
                                                @foreach($colors as $color)
                                                    <li>
                                                        <input type="checkbox" name="color-filter" class=""
                                                               value="{{ $color->getId() }}"> {{ $color->getName() }}
                                                    </li>
                                                @endforeach()
                                            </ol>
                                        </dd>
                                    @endif
                                    @if(count($licenses) > 0)
                                        <dt class="last even">{{ trans('frontend/articles.shop_by.licence') }}</dt>
                                        <dd class="last even">
                                            <ol>
                                                @foreach($licenses as $license)
                                                    <li>
                                                        <input type="checkbox" name="color-filter" class=""
                                                               value="{{ $license->getId() }}"> {{ $license->getName() }}
                                                    </li>
                                                @endforeach()
                                            </ol>
                                        </dd>
                                    @endif
                                </dl>
                            </div>
                        </div>

                        <div class="block block-cart">
                            <div class="block-title ">{{ trans('frontend/articles.my_cart.title') }}</div>
                            <div class="block-content">
                                <div class="summary">
                                    <p class="amount">{{ trans('frontend/articles.my_cart.there_are') }} <a
                                                href="shopping_cart.html">{{ trans_choice('frontend/articles.my_cart.articles', ['quantity' => 1]) }}</a> {{ trans('frontend/articles.my_cart.in_your_cart') }}
                                        .
                                    </p>
                                    <p class="subtotal"><span
                                                class="label">{{ trans('frontend/articles.my_cart.subtotal') }}</span>
                                        <span class="price">$42.99</span>
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
                                            <p class="product-name"><a href="shopping_cart.html">Caramelos azules</a>
                                            </p>
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
                                            <p class="product-name"><a href="shopping_cart.html"> Ositos de
                                                    gominola </a>
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

@section('scripts_body')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/bootstrap-slider.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#price_filter").slider({}).on('slide', function () {
                $("#price-filter-value").val("€" + $('#price_filter').slider('getValue')[0] + " - €" + $('#price_filter').slider('getValue')[1]);
            });
        });
    </script>
@stop