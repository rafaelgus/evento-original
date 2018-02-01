@extends('frontend.layouts.app')

@section('content')

    <!-- main-container -->
    <div class="main-container col2-right-layout">
        <div class="main container">
            <div class="row">
                <section class="col-sm-9 wow bounceInUp animated">
                    <div class="col-main">
                        <div class="my-account">
                            <div class="page-title">
                                <h2>{{ trans('frontend/affiliates.center_of_affiliates') }}</h2>
                            </div>
                            <div class="dashboard affiliates">
                                <div>
                                    <h3>{{ trans('frontend/affiliates.your_id_is') }}: <span class="affiliate-code">{{ $customer->getAffiliateCode() }}</span></h3>

                                    <h2>{{ trans('frontend/affiliates.how_to_use') }}</h2>
                                    <p> {!! trans('frontend/affiliates.how_to_use_description') !!}</p>

                                    <p class="domain">{{ domain_url() }}/slug<span style="color:#e94d65;">?ref={{ $customer->getAffiliateCode() }}</span></p>

                                    <p>{!! trans('frontend/affiliates.how_to_use_description_2') !!}</p>
                                </div>


                            </div>
                        </div>
                    </div>
                </section>

                @include('frontend.partials.my_account_sidebar')

            </div>
        </div>
    </div>
    <!--End main-container -->
@endsection