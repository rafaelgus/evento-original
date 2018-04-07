@extends('frontend.layouts.app')

@section('scripts_body')
    <style>
        .category-products .products-grid {
            margin: 0 !important;
        }

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

        .col-main {
            width: 100%;
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
                        <li class="category1601"><strong>{{ trans('designer.my_designs_rejected.title') }}</strong></li>
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
                            <h2 class="page-heading"><span class="page-heading-title">{{ trans('designer.my_designs.title') }}</span>
                            </h2>
                        </div>
                    </div>

                    <div class="state_bar">
                        <ul id="checkout-progress-state" class="checkout-progress">
                            <li><a href="{{route('designer.myDesigns')}}">{{ trans('designer.status.in_process') }}</a></li>
                            <li><a href="{{route('designer.myDesignsInReview')}}">{{ trans('designer.status.in_review') }}</a></li>
                            <li class="active first"><a href="{{route('designer.myDesignsRejected')}}">{{ trans('designer.status.rejected') }}</a></li>
                            <li><a href="{{route('designer.myDesignsPublished')}}">{{ trans('designer.status.published') }}</a></li>
                        </ul>
                    </div>

                    <a href="{{ route('designer.create') }}" class="button link-button">{{ trans('designer.new_design') }}</a>

                    <p>{{ trans('designer.my_designs_rejected.description') }}</p>

                    <article class="col-main">
                        <div class="category-products">
                            <ul class="products-grid">
                                @forelse($designs as $design)
                                    <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                        <div class="item-inner">
                                            <div class="item-img">
                                                <div class="item-img-info"><a href="{{ route('show_rejected', $design->getId()) }}" title="{{ $design->getName() }}" class="product-image"><img src="{{ get_design_image($design) }}" alt="{{ $design->getName() }}"></a>
                                                </div>
                                            </div>
                                            <div class="item-info">
                                                <div class="info-inner">
                                                    <div class="item-title"> <a title="{{ $design->getName() }}" href="{{ route('show_rejected', $design->getId()) }}"> {{ $design->getName() }} </a> </div>
                                                    <div>{{ $design->getCreatedAt()->format('d/m/Y h:i') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <i>{{ trans('designer.empty') }}</i>
                                @endforelse
                            </ul>
                        </div>
                    </article>
                    <!--	///*///======    End article  ========= //*/// -->
                </div>

                @include('frontend/partials/my_account_sidebar')

            </div>
        </div>
    </section>
    <!-- Main Container End -->
@endsection
