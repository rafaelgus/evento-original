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
                                <h2>{{ trans('frontend/payouts.title') }}</h2>
                            </div>
                            <div class="dashboard">
                                @include('backend.messages.session')

                                <div class="recent-payouts">
                                    <strong class="title-buttons">{{ trans('frontend/payouts.all') }}</strong>
                                    <div class="table-responsive">
                                        <table class="data-table" id="my-payouts-table">
                                            <col>
                                            <col>
                                            <col>
                                            <col width="1">
                                            <col width="1">
                                            <col width="1">
                                            <thead>
                                            <tr class="first last">
                                                <th>Fecha</th>
                                                <th><span class="nobr">Total</span></th>
                                                <th>Estado</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($payouts as $payout)
                                                <tr class="first odd">
                                                    <td>{{ $payout->getDate()->format('d-m-Y') }}</td>

                                                    <td><span class="price">{{ formatted_money($payout->getOriginalMoney()) }}</span></td>
                                                    <td><em>{{ trans('payouts.status.' . $payout->getStatus() ) }}</em></td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4">{{ trans('frontend/payouts.empty') }}</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>

                                        {{ $payouts->links() }}
                                    </div>
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