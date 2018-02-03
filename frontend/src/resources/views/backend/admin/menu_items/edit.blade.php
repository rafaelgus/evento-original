@extends('backend.layouts.app')

@section('scripts_head')
    <link href="/backend/plugins/select2/select2.min.css" rel="stylesheet" type="text/css"/>
@stop

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
                    <form role="form" class="form-horizontal" action="{{ "/management/menu-item/" . $menuItem->getId() }}" method="POST">
                        <div class="box-body">
                            @include('backend.messages.session')

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">

                            <h4>Menu Item</h4>

                            <div class="form-group {{ $errors->has('menu_id') ? 'has-error' : '' }}">
                                <label for="inputTitle" class="col-sm-2 control-label">{{ trans('backend/menu_item.menu') }}</label>
                                <div class="col-sm-10">
                                    <select name="menu_id" class="form-control">
                                        @foreach($menus as $menu)
                                            <option value="{{ $menu->getId() }}" {{ (old('menu_id', ($menuItem->getMenu() ? $menuItem->getMenu()->getId() : '')) == $menu->getId() ? "selected" : "") }}>{{ $menu->getName() }}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('menu_id', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                <label for="inputTitle" class="col-sm-2 control-label">{{ trans('backend/menu_item.title') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputTitle" name="title" required
                                           placeholder="{{ trans('backend/menu_item.title') }}" value="{{ old('title', $menuItem->getTitle()) }}">
                                    {!! $errors->first('title', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                                <label for="inputCategory" class="col-sm-2 control-label">{{ trans('backend/menu_item.category') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control select2" name="category_id" id="inputCategory" style="width: 100%">
                                        <option></option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->getId() }}"  {{ (old('category_id', ($menuItem->getCategory() ? $menuItem->getCategory()->getId() : '')) == $category->getId() ? "selected" : "") }}>
                                                {{ $category->getName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('category_id', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
                                <label for="inputUrl" class="col-sm-2 control-label">{{ trans('backend/menu_item.url') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputUrl" name="url"
                                           placeholder="{{ trans('backend/menu_item.url') }}" value="{{ old('url', $menuItem->getUrl()) }}">
                                    {!! $errors->first('url', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('position') ? 'has-error' : '' }}">
                                <label for="inputPosition" class="col-sm-2 control-label">{{ trans('backend/menu_item.position') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputPosition" name="position" value="{{ old('position', $menuItem->getPosition()) }}"
                                           placeholder="{{ trans('backend/menu_item.position') }}">
                                    {!! $errors->first('position', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('visible') ? 'has-error' : '' }}">
                                <label for="inputVisible" class="col-sm-2 control-label">{{ trans('backend/menu_item.visible') }}</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" class="checkbox" id="inputVisible" name="visible" {{ ($menuItem->getVisible() ? 'checked' : '') }}>
                                    {!! $errors->first('position', '<span class="help-block">* :message</span>') !!}
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
    <script src="/backend/plugins/select2/select2.full.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#inputCategory").select2({
                placeholder: "Seleccione una categoria si corresponde"
            });

            $("#inputCategory").change(function () {
                var categorySelected = $(this).val();

                if (categorySelected) {
                    $('#inputUrl').prop('disabled', true);
                } else {
                    $('#inputUrl').prop('disabled', false);
                }
            });
        });
    </script>
@endsection
