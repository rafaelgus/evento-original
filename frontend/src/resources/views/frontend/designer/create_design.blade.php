@extends('frontend.layouts.app')

@section('scripts_body')
    <style>
        .category-products .products-grid {
            margin: 0 !important;
        }

        .new-design {
            margin-bottom: 1rem !important;
        }
    </style>
@stop

@section('content')
    <section class="main-container col1-layout">
        <div class="main container">
            <div class="account-login">
                <div class="page-title">
                    <h2>{{ trans('designer.create.title') }}</h2>
                </div>

                <fieldset>
                    <div class="col-2">
                        <div class="content">

                            <p>{{ trans('designer.create.description') }}</p>

                            <div class="category-products">
                                <ul class="products-grid">
                                    <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                        <div class="item-inner">
                                            <div class="item-img">
                                                <div class="item-img-info"><a href="{{ route('designer.createEdiblePaper') }}" title="{{ trans('designer.edible_paper.title') }}" class="product-image"><img src="/images/edible_paper.jpg" alt="{{ trans('designer.edible_paper.title') }}"></a>
                                                </div>
                                            </div>
                                            <div class="item-info">
                                                <div class="info-inner">
                                                    <div class="item-title"> <a title="{{ trans('designer.edible_paper.title') }}" href="{{ route('designer.createEdiblePaper') }}"> {{ trans('designer.edible_paper.title') }} </a> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                        <div class="item-inner">
                                            <div class="item-img">
                                                <div class="item-img-info"><a href="{{ route('designer.designMug') }}" title="{{ trans('designer.mug.title') }}" class="product-image"><img src="/images/mug.jpg" alt="{{ trans('designer.mug.title') }}"></a>
                                                </div>
                                            </div>
                                            <div class="item-info">
                                                <div class="info-inner">
                                                    <div class="item-title"> <a title="{{ trans('designer.mug.title') }}" href="{{ route('designer.designMug') }}"> {{ trans('designer.mug.title') }} </a> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </fieldset>

            </div>
        </div>
    </section>
@stop

