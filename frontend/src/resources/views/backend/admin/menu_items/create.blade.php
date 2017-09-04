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
                    <form role="form" class="form-horizontal" action="/management/menu-item" method="POST">
                        <div class="box-body">
                            @include('backend.messages.session')

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <h4>Item</h4>

                            <div class="form-group {{ $errors->has('menu_id') ? 'has-error' : '' }}">
                                <label for="inputTitle" class="col-sm-2 control-label">{{ trans('backend/menu_item.menu') }}</label>
                                <div class="col-sm-10">
                                    <select name="menu_id" class="form-control">
                                        @foreach($menus as $menu)
                                            <option  value="{{ $menu->getId() }}">{{ $menu->getName() }}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('menu_id', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                <label for="inputTitle" class="col-sm-2 control-label">{{ trans('backend/menu_item.title') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputTitle" name="title" required
                                           placeholder="{{ trans('backend/menu_item.title') }}" value="{{ old('title') }}">
                                    {!! $errors->first('title', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
                                <label for="inputUrl" class="col-sm-2 control-label">{{ trans('backend/menu_item.url') }}</label>
                                <div class="col-sm-10">
                                    <input type="url" class="form-control" id="inputUrl" name="url"
                                           placeholder="{{ trans('backend/menu_item.url') }}" required value="{{ old('url') }}">
                                    {!! $errors->first('url', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                <label for="inputImage" class="col-sm-2 control-label">{{ trans('backend/menu_item.image') }} (246x100)</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="inputImage" name="name"
                                           placeholder="{{ trans('backend/menu_item.image') }}" value="{{ old('image') }}">
                                    {!! $errors->first('image', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('position') ? 'has-error' : '' }}">
                                <label for="inputPosition" class="col-sm-2 control-label">{{ trans('backend/menu_item.position') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputPosition" name="position" value="{{ old('position', 1) }}"
                                           placeholder="{{ trans('backend/menu_item.position') }}">
                                    {!! $errors->first('position', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('visible') ? 'has-error' : '' }}">
                                <label for="inputVisible" class="col-sm-2 control-label">{{ trans('backend/menu_item.visible') }}</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" class="checkbox" id="inputVisible" name="visible" checked>
                                    {!! $errors->first('position', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <!-- Horizontal Form -->
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Subitems</h3>
                                </div>
                                <div class="box-body">
                                    <div class="subitems" id="subitems">

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputTitle" class="col-sm-2 control-label">{{ trans('backend/menu_item.title') }}</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputTitle" name="sub_items_titles[]" required
                                                           placeholder="{{ trans('backend/menu_item.title') }}" value="{{ old('title') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="inputUrl" class="col-sm-2 control-label">{{ trans('backend/menu_item.url') }}</label>
                                                <div class="col-sm-10">
                                                    <input type="url" class="form-control" id="inputUrl" name="sub_items_urls[]" required
                                                           placeholder="{{ trans('backend/menu_item.url') }}" value="{{ old('url') }}">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    {!! $errors->first('sub_items.title', '<span class="help-block">* :message</span>') !!}
                                    {!! $errors->first('sub_items.url', '<span class="help-block">* :message</span>') !!}

                                    <button type="button" class="btn btn-primary pull-right" id="add-sub-item"><i class="fa fa-plus"></i>Agregar subitem</button>
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

@section('scripts_body')
    <script>
        $('#add-sub-item').click(function () {
            $('#subitems').append("<div class=col-sm-6><div class=form-group><label class=\"col-sm-2 control-label\"for=inputTitle>{{ trans('backend/menu_item.title') }}</label><div class=col-sm-10><input class=form-control id=inputTitle name=sub_items_titles[] required placeholder=\"{{ trans('backend/menu_item.title') }}\"value=\"{{ old('title') }}\"></div></div></div><div class=col-sm-6><div class=form-group><label class=\"col-sm-2 control-label\"for=inputUrl>{{ trans('backend/menu_item.url') }}</label><div class=col-sm-10><input class=form-control id=inputUrl name=sub_items_urls[] required placeholder=\"{{ trans('backend/menu_item.url') }}\"value=\"{{ old('url') }}\"type=url></div></div></div>");
        });
    </script>
@endsection