@extends('backend.layouts.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('backend/menus.title') }}
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i>  {{ trans('backend/menus.title') }}</li>
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
                    <form role="form" class="form-horizontal" action="/management/menu" method="POST">
                        <div class="box-body">
                            @include('backend.messages.session')

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <h4>Item</h4>

                            <div class="form-group">
                                <label for="inputTitle" class="col-sm-2 control-label">{{ trans('backend/menu_item.title') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputTitle" name="name"
                                           placeholder="{{ trans('backend/menu_item.title') }}" value="{{ old('title') }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputUrl" class="col-sm-2 control-label">{{ trans('backend/menu_item.url') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputUrl" name="name"
                                           placeholder="{{ trans('backend/menu_item.url') }}" value="{{ old('url') }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputImage" class="col-sm-2 control-label">{{ trans('backend/menu_item.image') }} (246x100)</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="inputImage" name="name"
                                           placeholder="{{ trans('backend/menu_item.image') }}" value="{{ old('image') }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputPosition" class="col-sm-2 control-label">{{ trans('backend/menu_item.position') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputPosition" name="position" value="1"
                                           placeholder="{{ trans('backend/menu_item.position') }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <!-- Horizontal Form -->
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Subitems</h3>
                                </div>
                                <div class="box-body">
                                    <div class="subitem">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputTitle" class="col-sm-2 control-label">{{ trans('backend/menu_item.title') }}</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputTitle" name="name"
                                                           placeholder="{{ trans('backend/menu_item.title') }}" value="{{ old('title') }}">
                                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputUrl" class="col-sm-2 control-label">{{ trans('backend/menu_item.url') }}</label>
                                                <div class="col-sm-10">
                                                    <input type="url" class="form-control" id="inputUrl" name="name"
                                                           placeholder="{{ trans('backend/menu_item.url') }}" value="{{ old('url') }}">
                                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary pull-right"><i class="fa fa-plus"></i>Agregar subitem</button>
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
