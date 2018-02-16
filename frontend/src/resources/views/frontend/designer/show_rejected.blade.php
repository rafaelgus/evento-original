@extends('frontend.layouts.app')

@section('scripts_header')
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/9.8.1/css/bootstrap-slider.min.css">

    <style>
        .category-products .products-grid {
            margin: 0 !important;
        }

        .preview-image {
            width: 20%;
        }

        .preview-image-container {
            text-align: center;
        }

        .slider.slider-horizontal {
            display: block !important;
        }

        .price-value {
            font-weight: bold !important;
        }

        .earn-value {
            font-weight: bold !important;
        }

        .observation-desc {
            text-align: left;
            font-size: 2rem;
            padding-top: 1rem;
        }
    </style>

    <link href="/backend/plugins/select2/select2.min.css" rel="stylesheet" type="text/css"/>
@stop

@section('content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <ul>
                        <li class="home"><a href="/" title="Go to Home Page">{{ trans('designer.title') }}</a> <span>/</span></li>
                        <li class="category1601"><strong>{{ trans('designer.show_rejected.title') }}</strong></li>
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
                <div class="col-sm-12">
                    <div class="category-description std">
                        <div class="slider-items-products">
                            <h2 class="page-heading"><span class="page-heading-title">{{ trans('designer.show_rejected.title') }}</span>
                            </h2>
                            <p class="category-description">
                                {{ trans('designer.show_rejected.description') }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <div class="preview-image-container">
                            <img class="preview-image" alt="{{ $design->getName() }}" src="{{ $design->getImage() }}"/>

                            <p class="observation-desc">
                                {{ $design->getObservation() }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Main Container End -->
@endsection

@section('scripts_body')

@stop