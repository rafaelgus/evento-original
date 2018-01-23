@extends('frontend.layouts.app')

@section('scripts_header')
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/css/bootstrap-slider.min.css">
    <link rel="stylesheet" type="text/css" href="/css/loading.css"/>
    <link rel="stylesheet" type="text/css" href="/css/spinner.css"/>

    <style>
        .products-grid .item .item-inner .item-img .item-img-info a.product-image img {
            max-height: 270px;
        }
    </style>
@stop

@section('content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul>
                        <li class="home"><a href="/" title="Go to Home Page">Home</a> <span>/</span></li>
                        <li class="category1601"><strong>{{ trans('frontend/design.edible_paper.title') }}</strong></li>
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
                            <h2 class="page-heading"><span class="page-heading-title">{{ trans('frontend/design.edible_paper.title') }}</span>
                            </h2>
                            <p class="category-description">
                                {{ trans('frontend/design.edible_paper.description') }}
                            </p>
                        </div>
                    </div>
                    <article class="col-main">
                        <div class="category-products">
                            <ul class="products-grid">
                                @foreach($circularDesignVariants as $variant)
                                    <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                        <div class="item-inner">
                                            <div class="item-img">
                                                <div class="item-img-info">
                                                    <a href="{{ route('circular_design_variant_editor', $variant->getId()) }}" title="{{ $variant->getName() }}" class="product-image">
                                                        <img src="{{ $variant->getPreviewImage() }}"
                                                             alt="{{ $variant->getName() }}">
                                                    </a>

                                                    <div class="box-hover">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item-info">
                                                <div class="info-inner">
                                                    <div class="item-title"><a title="{{ $variant->getName() }}" href="{{ route('circular_design_variant_editor', $variant->getId()) }}"> {{ $variant->getName() }} </a></div>
                                                    <div><span>({{ $variant->getDesignMaterialSize()->getName() }})</span></div>
                                                    <div class="item-content">
                                                        <div class="item-price">
                                                            <div class="price-box"><span class="regular-price"><span class="price">{{ formatted_money($variant->getMoney()) }}</span> </span> </div>
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

            </div>
        </div>
    </section>
    <!-- Main Container End -->

    <div id="result"></div>

@endsection

@section('scripts_body')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/bootstrap-slider.min.js"></script>
@stop