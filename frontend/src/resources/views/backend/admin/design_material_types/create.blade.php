@extends('backend.layouts.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('texts.sections.design_material_types.title') }}
            <small>{{ trans('texts.sections.design_material_types.new') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i>  {{ trans('texts.sections.design_material_types.title') }}</li>
            <li class="active">{{ trans('texts.sections.design_material_types.new') }}</li>
        </ol>
    </section>
@stop

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-danger">
                    <!-- form start -->
                    <form role="form" class="form-horizontal" action="/management/design-material-type" method="POST">
                        <div class="box-body">
                            @include('backend.messages.session')

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.design_material_types.name') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="name"
                                           placeholder="{{ trans('texts.sections.design_material_types.name') }}" value="{{ old('name') }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label for="inputDescription" class="col-sm-2 control-label">{{ trans('texts.sections.design_material_types.description') }}</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="description" id="inputDescription"></textarea>
                                    {!! $errors->first('description', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-danger pull-right">{{ trans('buttons.save') }}</button>
                        </div>
                    </form>
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
@endsection
