@extends('backend.layouts.app')

@section('scripts_head')
@stop

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('orders.title') }}
            <small>{{ trans('orders.show') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i> {{ trans('orders.title') }}</li>
            <li class="active">{{ trans('orders.show') }}</li>
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
                        <h3>Orden</h3>
                        <dl class="dl-horizontal">
                            <dt>{{trans('orders.id')}}</dt>
                            <dd>{{$order->getId()}}</dd>

                            <dt>{{trans('orders.created_date')}}</dt>
                            <dd>{{$order->getCreateDate()->format('d-m-Y H:i:s')}}</dd>

                            <dt>{{trans('orders.status')}}</dt>
                            <dd>{{$order->getStatus()}}</dd>

                            @if($order->getShipping())
                                <dt>{{trans('orders.shipping')}}</dt>
                                <dd>{{$order->getShipping()->getAddress()->getAddress()}}</dd>
                            @else
                                <dt>{{trans('orders.shipping')}}</dt>
                                <dd>Retiro en sucursal</dd>
                            @endif
                        </dl>
                        <hr>
                        <h3>Facturacion</h3>
                        <dl class="dl-horizontal">
                            <dt>Nombre</dt>
                            <dd>{{$order->getBilling()->getName()}}</dd>

                            <dt>Apellido</dt>
                            <dd>{{$order->getBilling()->getLastName()}}</dd>

                            <dt>Compania</dt>
                            <dd>{{$order->getBilling()->getCompany()}}</dd>

                            <dt>Direccion</dt>
                            <dd>{{$order->getBilling()->getAddress()->getAddress()}}</dd>

                            <dt>Pais</dt>
                            <dd>{{$order->getBilling()->getAddress()->getCountry()->getName()}}</dd>

                            <dt>Ciudad</dt>
                            <dd>{{$order->getBilling()->getAddress()->getCity()}}</dd>
                        </dl>
                        <hr>
                        <h3>Datos extra</h3>
                        <dl class="dl-horizontal">
                            <dt>Comentarios</dt>
                            <dd>{{$order->getComment()}}</dd>

                            @if($order->getShipping())
                            <dt>Numero de seguimiento</dt>
                            <dd>{{$order->getShipping()->getTrackingNumber()}}</dd>
                            @endif
                        </dl>

                        <div>
                            <table class="table table-striped table-bordered dt-responsive nowrap"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>{{trans('orders.article')}}</th>
                                    <th>{{trans('orders.quantity') }}</th>
                                    <th>{{trans('orders.price')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->getOrdersDetail() as $orderDetail)
                                    <tr>
                                        <td>{{ ($orderDetail->getArticle()) ? $orderDetail->getArticle()->getName() : 'Descuento'}}</td>
                                        <td>
                                            {{ $orderDetail->getArticle()->getName() }}

                                            @if($orderDetail->getArticle()->getDesign())
                                                <a href="{{ route(
                                                'admin.designs.download',
                                                [
                                                    $orderDetail->getArticle()->getDesign()->getId(),
                                                    $orderDetail->getQuantity(),
                                                    $orderDetail->getArticle()->getSlug()
                                                ])}}"
                                                >
                                                    Descargar diseño
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{ $orderDetail->getQuantity() }}</td>
                                        <td>{{ formatted_money($orderDetail->getMoney()) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($order->getReferralVisitorEvent())

                            @php
                                $visitorEvent = $order->getReferralVisitorEvent();
                            @endphp

                            <div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="panel-ref">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#panel-ref-colapse" aria-expanded="true"
                                               aria-controls="panel-data-colapse">
                                                {{trans('orders.affiliate_referral_data')}}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="panel-ref-colapse" class="panel-collapse collapse out" role="tabpanel"
                                         aria-labelledby="panel-data">
                                        <div class="panel-body">
                                            <dl class="dl-horizontal">
                                                <dt>URL</dt>
                                                <dd>{{ $visitorEvent->getUrl() }}</dd>

                                                <dt>Codigo</dt>
                                                <dd>{{ $visitorEvent->getAffiliateCodeReferral() }}</dd>

                                                <dt>IP</dt>
                                                <dd>{{ $visitorEvent->getIp() }}</dd>

                                                <dt>Fecha</dt>
                                                <dd>{{ $visitorEvent->getCreatedAt()->format('m-d-Y H:i:s') }}</dd>

                                                @if($visitorEvent->getVisitorLanding()->getUser())
                                                    <dt>Nombre</dt>
                                                    <dd>{{ $visitorEvent->getVisitorLanding()->getUser()->getName() }}</dd>
                                                    <dt>Email</dt>
                                                    <dd>{{ $visitorEvent->getVisitorLanding()->getUser()->getEmail() }}</dd>
                                                @endif
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        @include('backend.messages.session')
                        <form method="POST" class="form-horizontal" action="/management/orders/{{$order->getId()}}/update">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            @if($order->getShipping())


                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">Estado</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="status">
                                        <option value="pending">Pendiente</option>
                                        <option value="prepare">Preparado</option>
                                        <option value="sent">Enviado</option>
                                        <option value="delivered">Entregado</option>
                                    </select>
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Numero de seguimiento</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="trackingNumber"
                                           placeholder="Numero de seguimiento" value="{{ old('trackingNumber', $order->getShipping()->getTrackingNumber()) }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Commentario</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="comment"
                                           placeholder="comentario (opcional)" value="{{ old('comment') }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-danger pull-right">Guardar</button>
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-2 control-label">Comentario</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputName" name="comment"
                                               placeholder="comentario (opcional)" value="{{ old('comment') }}">
                                        {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-danger pull-right">Marcar como entregado</button>
                                </div>
                            @endif
                        </form>
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