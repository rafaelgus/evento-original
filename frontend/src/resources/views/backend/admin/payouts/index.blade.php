@extends('backend.layouts.app')

@section('scripts_head')
    <link href="/backend/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css">
    <link href="/backend/plugins/datatables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet"
          type="text/css">
    <style>
        .form-inline {
            display: inline-block;
        }
    </style>
@stop

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('texts.sections.payouts.title') }}
            <small>{{ trans('texts.sections.payouts.view') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i> {{ trans('texts.sections.payouts.title') }}</li>
            <li class="active">{{ trans('texts.sections.payouts.view') }}</li>
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
                        <table id="tags-table" class="table table-striped table-bordered dt-responsive nowrap"
                               cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('payouts.date') }}</th>
                                <th>{{ trans('payouts.amount') }}</th>
                                <th>{{ trans('payouts.status') }}</th>
                                <th>{{ trans('payouts.receiver') }}</th>
                                <th style="width: 120px">Accion</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($payouts as $payout)
                                <tr class="first odd">
                                    <td>{{ $payout->getId() }}</td>
                                    <td>{{ $payout->getDate()->format('d-m-Y') }}</td>

                                    <td><span class="price">{{ formatted_money($payout->getOriginalMoney()) }}</span>
                                    </td>
                                    <td><em>{{ trans('payouts.status_enum.' . $payout->getStatus() ) }}</em></td>
                                    <td>{{ $payout->getUser()->getName() }}</td>
                                    <td style="white-space:nowrap;">
                                        <a class="btn btn-info btn-xs"
                                           href="{{route('admin.payouts.show', $payout->getId())}}">
                                            <span class="fa fa-info-circle"></span>
                                        </a>

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
                                                <span class="fa fa-check"></span>
                                            </a>
                                        @endif

                                        @if($payout->getStatus() == \EventoOriginal\Core\Enums\PayoutStatus::PENDING_APPROVAL)
                                            {{ Form::open([
                                                    'route' => ['admin.payouts.cancel', $payout->getId()],
                                                    'method' => 'post',
                                                    'class' => 'form-inline'
                                                ])
                                            }}

                                            @include('backend.includes.confirm', [
                                                    'id' => 'payout-cancel-' . $payout->getId(),
                                                    'model_id' => $payout->getId(),
                                                    'labelled_by' => 'payout-cancel-' . $payout->getId(),
                                                    'title' => trans('payouts.cancel_payout_dialog_title'),
                                                    'question' => trans('payouts.cancel_payout_dialog_question'),
                                                    'route' => 'admin.payouts.cancel'
                                            ])

                                            {{Form::close()}}

                                            <a class="btn btn-danger btn-xs" data-toggle="modal"
                                               data-target="#payout-cancel-{{$payout->getId()}}">
                                                <span class="fa fa-close"></span>
                                            </a>
                                        @endif
                                    </td>
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
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section><!-- /.content -->
@endsection

@section('scripts_body')
    <script src="/backend/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/backend/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="/backend/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
    <script src="/backend/plugins/datatables/extensions/Responsive/js/responsive.bootstrap.min.js"></script>
@endsection