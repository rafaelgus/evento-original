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

                            <dd>
                                @if($design->getStatus() == \EventoOriginal\Core\Enums\DesignStatus::IN_REVIEW)
                                    {{ Form::open([
                                            'route' => ['admin.designs.approve', $design->getId()],
                                            'method' => 'post',
                                            'class' => 'form-inline'
                                        ])
                                    }}

                                    @include('backend.includes.confirm', [
                                            'id' => 'design-approve-' . $design->getId(),
                                            'model_id' => $design->getId(),
                                            'labelled_by' => 'design-approve-' . $design->getId(),
                                            'title' => trans('designs.approve_design_dialog_title'),
                                            'question' => trans('designs.approve_design_dialog_question'),
                                            'route' => 'admin.designs.approve'
                                    ])

                                    {{Form::close()}}

                                    <a class="btn btn-success btn-xs" data-toggle="modal"
                                       data-target="#design-approve-{{$design->getId()}}">
                                        <span class="fa fa-check">{{trans('designs.approve') }}</span>
                                    </a>

                                    <a class="btn btn-danger btn-xs" href="{{ route('admin.designs.rejectForm', $design->getId()) }}">
                                        <span class="fa fa-close">{{ trans('designs.reject') }}</span>
                                    </a>
                                @endif
                            </dd>
                        </dl>

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