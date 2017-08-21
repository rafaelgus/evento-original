@extends('frontend.layouts.app')

@section('scripts_header')
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/css/bootstrap-slider.min.css">
    <link rel="stylesheet" type="text/css" href="/css/loading.css"/>
    <link rel="stylesheet" type="text/css" href="/css/spinner.css"/>
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
                                        <label for="sort-by-filter" class="left">{{ trans('frontend/articles.sort_by') }}: </label>
                                        <select id="sort-by-filter" name="sort-by-filter" class="select-filter">
                                            <option value="position">
                                                {{ trans('frontend/articles.position') }}
                                            </option>
                                            <option value="price_low">{{ trans('frontend/articles.price_low') }}</option>
                                            <option value="price_up">
                                                {{ trans('frontend/articles.price_up') }}
                                            </option>
                                            <option value="name">
                                                {{ trans('frontend/articles.name') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-sm-7 col-md-5">
                                    <div class="pager">
                                        <div class="pages">
                                            <label>{{ trans('frontend/articles.page') }}:</label>
                                            <ul class="pagination">

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12 col-md-2">
                                    <div id="limiter">
                                        <label for="page-limit">{{ trans('frontend/articles.view') }}: </label>
                                        <select id="page-limit" name="page-limit" class="select-filter">
                                            <option value="9" selected>09</option>
                                            <option value="15">15</option>
                                            <option value="20">20</option>
                                            <option value="30">30</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <article class="col-main">
                        <img src="images/Spinner.gif" class="loader"/>

                        <div class="category-products">
                            <ul class="products-grid">

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
                                        <dt class="even">{{ trans('frontend/articles.shop_by.category') }}</dt>
                                        <dd class="even">
                                            <ol>
                                                @foreach($category->getChildren() as $children)
                                                    <li>
                                                        <input type="checkbox" name="category-filter"
                                                               value="{{ $children->getId() }}"
                                                               onchange="applyFilter()"> {{ $children->getName() }}
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
                                                               value="{{ $brand->getId() }}"
                                                               onchange="applyFilter()"> {{ $brand->getName() }}
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
                                                               value="{{ $color->getId() }}"
                                                               onchange="applyFilter()"> {{ $color->getName() }}
                                                    </li>
                                                @endforeach()
                                            </ol>
                                        </dd>
                                    @endif

                                    @if(count($flavours) > 0)
                                        <dt class="odd">{{ trans('frontend/articles.shop_by.flavour') }}</dt>
                                        <dd class="odd">
                                            <ol>
                                                @foreach($flavours as $flavour)
                                                    <li>
                                                        <input type="checkbox" name="flavour-filter" class=""
                                                               value="{{ $flavour->getId() }}"
                                                               onchange="applyFilter()"> {{ $flavour->getName() }}
                                                    </li>
                                                @endforeach()
                                            </ol>
                                        </dd>
                                    @endif

                                    @if(count($healthys) > 0)
                                        <dt class="odd">{{ trans('frontend/articles.shop_by.healthy') }}</dt>
                                        <dd class="odd">
                                            <ol>
                                                @foreach($healthys as $healthy)
                                                    <li>
                                                        <input type="checkbox" name="healthy-filter" class=""
                                                               value="{{ $healthy->getId() }}"
                                                               onchange="applyFilter()"> {{ $healthy->getName() }}
                                                    </li>
                                                @endforeach()
                                            </ol>
                                        </dd>
                                    @endif

                                    @if(count($licenses) > 0)
                                        <dt class="last even">{{ trans('frontend/articles.shop_by.license') }}</dt>
                                        <dd class="last even">
                                            <ol>
                                                @foreach($licenses as $license)
                                                    <li>
                                                        <input type="checkbox" name="license-filter" class=""
                                                               value="{{ $license->getId() }}"
                                                               onchange="applyFilter()"> {{ $license->getName() }}
                                                    </li>
                                                @endforeach()
                                            </ol>
                                        </dd>
                                    @endif
                                    @if(count($tags) > 0)
                                        <dt class="last even">{{ trans('frontend/articles.shop_by.licence') }}</dt>
                                        <dd class="last even">
                                            <ol>
                                                @foreach($tags as $tag)
                                                    <li>
                                                        <input type="checkbox" name="tag-filter" class=""
                                                               value="{{ $tag->getId() }}"
                                                               onchange="applyFilter()"> {{ $tag->getName() }}
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

    <div id="result"></div>

@endsection

@section('scripts_body')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/bootstrap-slider.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsrender/0.9.87/jsrender.min.js"></script>

    @include('frontend.articles.template')

    <script>
        $.views.settings.delimiters("<%", "%>");

        var categorySlug = "{{ $category->getSlug() }}";

        $('.products-grid').hide();
        $('.loader').show();

        function renderArticleTemplate(data) {
            var tmpl = $.templates("#articleTemplate");
            var html = tmpl.render(data);
            $(".products-grid").html(html);
        }

        function applyFilter() {
            $('.products-grid').hide();
            $('.loader').show();

            var pageSelected = 1;

            $.ajax({
                url: '/articles/' + categorySlug,
                type: 'GET',
                data: {
                    'subcategories': getCheckboxValues('category-filter'),
                    'brands': getCheckboxValues('brand-filter'),
                    'colors': getCheckboxValues('color-filter'),
                    'flavours': getCheckboxValues('flavour-filter'),
                    'licenses': getCheckboxValues('license-filter'),
                    'tags': getCheckboxValues('tag-filter'),
                    'healthys': getCheckboxValues('healthy-filter'),
                    'priceMin': $('#price_filter').slider('getValue')[0],
                    'priceMax': $('#price_filter').slider('getValue')[1],
                    'pageLimit': $('#page-limit').val(),
                    'page': pageSelected,
                    'orderBy': $('#sort-by-filter').val()
                },
                success: function (articles) {
                    renderArticleTemplate($.parseJSON(articles.data));
                    renderPagination(articles.pages);

                    $('.products-grid').show();
                    $('.loader').hide();
                },
                fail: function () {
                    renderArticleTemplate([]);
                    $('.products-grid').show();
                    $('.loader').hide();
                }
            });

            function renderPagination(pages) {
                $('.pagination').empty();
                $('.pagination').append('<li><a href="#">&laquo;</a></li>');
                for(i = 1; i <= pages; i++) {
                    var activeClass = "";

                    if (pageSelected === i) {
                        activeClass = "active";
                    }

                    $('.pagination').append('<li class="' + activeClass + '"><a id="page-' + i +'" class="pagination-page">' + i + '</a></li>')
                }
                $('.pagination').append('<li><a href="#">&raquo;</a></li>');
                $('.pagination-page').click(function(e) {
                    applyFilter();
                });
            }
        }

        function getCheckboxValues(name) {
            var values = [];

            $("input[name=" + name + "]:checked").each(function () {
                values.push($(this).val());
            });

            return values;
        }
    </script>

    <script>
        $(document).ready(function () {
            $("#price_filter").slider({}).on('slide', function () {
                $("#price-filter-value").val("€" + $('#price_filter').slider('getValue')[0] + " - €" + $('#price_filter').slider('getValue')[1]);
            }).on('slideStop', function () {
                applyFilter();
            });

            applyFilter();

            $('#page-limit').on('change', function () {
               applyFilter();
            });

            $('#sort-by-filter').on('change', function () {
                applyFilter();
            });
        });
    </script>
@stop