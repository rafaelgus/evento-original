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
                                <h2>{{ trans('movements.title') }}</h2>
                            </div>
                            <div class="dashboard">
                                @include('backend.messages.session')

                                <div class="recent-movements">
                                    <strong class="title-buttons">{{ trans('movements.all') }}</strong>
                                    <div class="table-responsive">
                                        <table class="data-table" id="my-movements-table">
                                            <col>
                                            <col>
                                            <col>
                                            <col width="1">
                                            <col width="1">
                                            <col width="1">
                                            <thead>
                                            <tr class="first last">
                                                <th>{{ trans('movements.date') }}</th>
                                                <th>{{ trans('movements.type') }}</th>
                                                <th><span class="nobr">{{ trans('movements.amount') }}</span></th>
                                                <th>{{ trans('movements.observations')  }}</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($movements as $movement)
                                                <tr class="first odd">
                                                    <td>{{ $movement->getDate()->format('d-m-Y') }}</td>
                                                    <td>{{ trans('movements.types.' . $movement->getType()) }}</td>
                                                    <td><span class="price">{{ formatted_money($movement->getAmountMoney()) }}</span></td>
                                                    @if($movement->getReferralOrder() && $movement->getReferralOrder()->getReferralVisitorEvent() && $movement->getReferralOrder()->getReferralVisitorEvent()->getType() == \EventoOriginal\Core\Enums\VisitorEventType::AFFILIATE_REFERRAL_ARRIVAL)
                                                        @php
                                                            $visitorEvent = $movement->getReferralOrder()->getReferralVisitorEvent();
                                                        @endphp

                                                        <td><b>{{ $visitorEvent->getArticle()->getName() }}</b> <br/> {{ $visitorEvent->getCreatedAt()->format('d-m-Y H:i:s') }}
                                                            <br/> {{ ($visitorEvent->getVisitorLanding()->getUser() ? $visitorEvent->getVisitorLanding()->getUser()->getEmail() : "") }}</td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4">{{ trans('movements.empty') }}</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>

                                        <div class="pages center-pagination">
                                            {{ $movements->links() }}
                                        </div>
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