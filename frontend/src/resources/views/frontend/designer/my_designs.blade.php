@extends('frontend.layouts.app')

@section('content')

    <section class="main-container col1-layout">
        <div class="main container">
            <div class="account-login">
                <div class="page-title">
                    <h2>{{ trans('designer.my_designs.title') }}</h2>
                </div>

                <fieldset>
                    <div class="col-2">
                        <div class="content">
                            <div class="state_bar">
                                <ul id="checkout-progress-state" class="checkout-progress">
                                    <li class="active first">En proceso</li>
                                    <li>En revisión</li>
                                    <li>Necesitan revisión</li>
                                </ul>
                            </div>

                            <p>{{ trans('designer.my_designs.description') }}</p>

                            <div class="category-products">
                                <ul class="products-grid">
                                    @forelse($designs as $design)
                                        <li class="item col-lg-3 col-md-3 col-sm-4 col-xs-6">
                                            <div class="item-inner">
                                                <div class="item-img">
                                                    <div class="item-img-info"><a href="#" title="{{ $design->getName() }}" class="product-image"><img src="{{ $design->getImage() }}" alt="{{ $design->getName() }}"></a>
                                                    </div>
                                                </div>
                                                <div class="item-info">
                                                    <div class="info-inner">
                                                        <div class="item-title"> <a title="Food Processor" href="#"> {{ $design->getName() }} </a> </div>
                                                        <div>{{ $design->getCreatedAt()->format('d/m/Y h:i') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        No hay
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </fieldset>

            </div>
        </div>
    </section>
@endsection
