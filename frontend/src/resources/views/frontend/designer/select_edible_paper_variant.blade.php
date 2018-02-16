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

        .products-grid .item .item-inner .item-img {
            min-height: 270px;
            display: table;
        }

        .products-grid .item .item-inner .item-img .item-img-info {
            height: 100%;
            display: table-cell;
            vertical-align: middle;
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
                        <li class="home"><a href="/" title="Go to Home Page">{{ trans('designer.title') }}</a> <span>/</span></li>
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
                <div class="col-sm-9">
                    <div class="category-description std">
                        <div class="slider-items-products">
                            <h2 class="page-heading"><span class="page-heading-title">{{ $variant->getName() }}</span>
                            </h2>
                            <p class="category-description">
                                Has seleccionado diseñar la siguiente variante
                            </p>
                        </div>
                    </div>
                    <section>
                        <div class="row">
                            <div class="col-md-5" style="position:relative; width: auto">
                                <img src="{{ $variant->getPreviewImage() }}" alt="{{ $variant->getName() }}"/>
                            </div>
                            <div class="col-md-5">
                                {{ trans('designer.select_edible_paper.description') }}

                                <ol>
                                    <br>

                                    <li>
                                        {{ trans('designer.select_edible_paper.use_editor.title') }}
                                        <br><br>

                                        <a class="button link-button" href="{{ route('designer.designEdiblePaper', $variant->getId()) }}">
                                            {{ trans('designer.select_edible_paper.use_editor.button') }}
                                        </a>
                                    </li>

                                    <br><br>

                                    <li>
                                        {{ trans('designer.select_edible_paper.download_template.title') }}

                                        <br>
                                        <br>

                                        <a class="button link-button" href="{{ route('designer.designEdiblePaper', $variant->getId()) }}">
                                            {{ trans('designer.select_edible_paper.download_template.button') }}
                                        </a>
                                    </li>
                                </ol>
                            </div>
                        </div>

                    </section>
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