@extends('backend.layouts.app')

@section('scripts_head')
@stop

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('texts.sections.payouts.title') }}
            <small>{{ trans('texts.sections.payouts.show') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i> {{ trans('texts.sections.payouts.title') }}</li>
            <li class="active">{{ trans('texts.sections.payouts.show') }}</li>
        </ol>
    </section>
@stop

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        @include('backend.messages.session')

                        <dl class="dl-horizontal">
                            <dt>{{trans('payouts.id')}}</dt>
                            <dd>{{$payout->getId()}}</dd>

                            <dt>{{trans('payouts.receiver')}}</dt>
                            <dd>{{$payout->getUser()->getName()}}</dd>

                            <dt>{{trans('payouts.date')}}</dt>
                            <dd>{{ $payout->getDate()->format('d-m-Y') }}</dd>

                            <dt>{{trans('payouts.gateway')}}</dt>
                            <dd>{{$payout->getGateway()}}</dd>

                            <dt>{{trans('payouts.status')}}</dt>
                            <dd>{{trans('payouts.status_enum.' . $payout->getStatus())}} </dd>

                            <dt>{{trans('payouts.amount')}}</dt>
                            <dd>{{formatted_money($payout->getOriginalMoney())}}</dd>
                            <dd>
                                @if($payout->getStatus() == \EventoOriginal\Core\Enums\PayoutStatus::PENDING_APPROVAL)
                                    {{ Form::open([
                                            'route' => ['admin.payouts.send', $payout->getId()],
                                            'method' => 'post',
                                            'class' => 'form-inline'
                                        ])
                                    }}

                                    @include('backend.includes.confirm', [
                                            'id' => 'payout-send-' . $payout->getId(),
                                            'model_id' => $payout->getId(),
                                            'labelled_by' => 'payout-send-' . $payout->getId(),
                                            'title' => trans('payouts.send_payout_dialog_title'),
                                            'question' => trans('payouts.send_payout_dialog_question'),
                                            'route' => 'admin.payouts.send'
                                    ])

                                    {{Form::close()}}

                                    <a class="btn btn-success btn-xs" data-toggle="modal"
                                       data-target="#payout-send-{{$payout->getId()}}">
                                        <span class="fa fa-check">{{trans('payouts.approve') }}</span>
                                    </a>
                                @endif
                            </dd>
                        </dl>

                        <div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="panel-data">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#panel-data-colapse" aria-expanded="true" aria-controls="panel-data-colapse">
                                            {{trans('payouts.data')}}
                                        </a>
                                    </h4>
                                </div>
                                <div id="panel-data-colapse" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="panel-data">
                                    <div class="panel-body">
                                        <samp>
                                           {!! array_beautifier(json_decode($payout->getRequestData(), true)) !!}
                                        </samp>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="panel-webhook-data">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#panel-webhook-data-colapse" aria-expanded="true" aria-controls="panel-data-colapse">
                                            {{trans('payouts.webhook_data')}}
                                        </a>
                                    </h4>
                                </div>
                                <div id="panel-webhook-data-colapse" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="panel-data">
                                    <div class="panel-body">
                                        <samp>
                                            {!! array_beautifier(json_decode($payout->getResponseData(), true)) !!}
                                        </samp>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="panel-last-movements">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" href="#panel-last-movements-colapse" aria-expanded="true" aria-controls="panel-data-colapse">
                                            {{trans('payouts.last_movements')}}
                                        </a>
                                    </h4>
                                </div>
                                <div id="panel-last-movements-colapse" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="panel-data">
                                    <div class="panel-body">
                                        <table class="table table-striped table-bordered dt-responsive nowrap"
                                               cellspacing="0" width="100%">
                                            <tbody>
                                                @foreach($lastMovements as $movement)
                                                    <tr>
                                                        <td>{{ $movement->getDate()->format('Y-m-d H:i:s') }}</td>
                                                        <td>{{ trans('movements.types.' . $movement->getType()) }}</td>
                                                        <td>{{ formatted_money($movement->getAmountMoney()) }}</td>
                                                        @if($movement->getReferralOrder() && $movement->getReferralOrder()->getReferralVisitorEvent())
                                                            @php
                                                                $visitorEvent = $movement->getReferralOrder()->getReferralVisitorEvent();
                                                            @endphp

                                                            <td><b>{{ ($visitorEvent->getArticle() ? $visitorEvent->getArticle()->getName() : "") }}</b> <br/> {{ $visitorEvent->getCreatedAt()->format('d-m-Y H:i:s') }}
                                                                <br/> {{ ($visitorEvent->getVisitorLanding()->getUser() ? $visitorEvent->getVisitorLanding()->getUser()->getEmail() : "") }}
                                                                <br/>
                                                                <a href="{{ route('admin.orders.show', ['id' => $movement->getReferralOrder()->getId()]) }}">Ver órden</a>
                                                            </td>
                                                        @else
                                                            <td></td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section><!-- /.content -->
@endsection

@section('scripts_body')

@endsection