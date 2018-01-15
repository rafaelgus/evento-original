@extends('backend.layouts.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('texts.sections.design_material_sizes.title') }}
            <small>{{ trans('texts.sections.design_material_sizes.new') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i>  {{ trans('texts.sections.design_material_sizes.title') }}</li>
            <li class="active">{{ trans('texts.sections.design_material_sizes.new') }}</li>
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
                    <form role="form" class="form-horizontal" action="/management/design-material-size" method="POST">
                        <div class="box-body">
                            @include('backend.messages.session')

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.design_material_sizes.name') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="name"
                                           placeholder="{{ trans('texts.sections.design_material_sizes.name') }}" value="{{ old('name') }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('horizontal_size') ? 'has-error' : '' }}">
                                <label for="inputHorizontalSize" class="col-sm-2 control-label">{{ trans('texts.sections.design_material_sizes.horizontal_size') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputHorizontalSize" name="horizontal_size"
                                           placeholder="{{ trans('texts.sections.design_material_sizes.horizontal_size') }}" value="{{ old('horizontal_size') }}">
                                    {!! $errors->first('horizontal_size', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('vertical_size') ? 'has-error' : '' }}">
                                <label for="inputVerticalSize" class="col-sm-2 control-label">{{ trans('texts.sections.design_material_sizes.vertical_size') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputVerticalSize" name="vertical_size"
                                           placeholder="{{ trans('texts.sections.design_material_sizes.vertical_size') }}" value="{{ old('vertical_size') }}">
                                    {!! $errors->first('vertical_size', '<span class="help-block">* :message</span>') !!}
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
