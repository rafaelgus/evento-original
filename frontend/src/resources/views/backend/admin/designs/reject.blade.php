@extends('backend.layouts.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Diseño
            <small>Ver</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i> Diseño</li>
            <li class="active">Ver</li>
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
                            <dt>ID</dt>
                            <dd>{{$design->getId()}}</dd>

                            <dt>Nombre</dt>
                            <dd>{{$design->getName()}}</dd>

                            <dt>Descripción</dt>
                            <dd>{{ $design->getDescription() }}</dd>

                            <dt>Comisión</dt>
                            <dd>{{ $design->getCommission()}}</dd>

                            <dt>Diseñador</dt>
                            <dd>{{ $design->getDesigner()->getNickName() }} </dd>
                        </dl>

                        <form role="form" class="form-horizontal" method="POST" action="{{ route('admin.designs.reject', $design->getId()) }}">
                            <div class="box-body">
                                @include('backend.messages.session')

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="form-group {{ $errors->has('observation') ? 'has-error' : '' }}">
                                    <label for="inputObservation"
                                           class="col-sm-2 control-label">Observaciones</label>
                                    <div class="col-sm-10">
                                        <textarea  required class="form-control" id="inputObservation" name="observation" rows="5"
                                                  placeholder="Describa el motivo de rechazo">{{ old('observation') }}</textarea>
                                        {!! $errors->first('observation', '<span class="help-block">* :message</span>') !!}
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary pull-right">Enviar rechazo</button>
                                </div>
                            </div>
                        </form>

                        <img src="{{ $design->getImage() }}">
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