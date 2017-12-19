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
                    <form role="form" class="form-horizontal" action="{{ "/management/menu-item/" . $subitem->getId() . "/edit-subitem" }}" method="POST" enctype="multipart/form-data">
                        <div class="box-body">
                            @include('backend.messages.session')

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">

                            <h4>Item para {{ $subitem->getParent()->getTitle() }}</h4>


                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                <label for="inputTitle" class="col-sm-2 control-label">{{ trans('backend/menu_item.title') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputTitle" name="title" required
                                           placeholder="{{ trans('backend/menu_item.title') }}" value="{{ old('title', $subitem->getTitle()) }}">
                                    {!! $errors->first('title', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                                <label for="inputCategory" class="col-sm-2 control-label">{{ trans('backend/menu_item.category') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control select2" name="category_id" id="inputCategory" style="width: 100%">
                                        <option></option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->getId() }}"  {{ (old('category_id', ($subitem->getCategory() ? $subitem->getCategory()->getId() : '')) == $category->getId() ? "selected" : "") }}>
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
                                           placeholder="{{ trans('backend/menu_item.url') }}" value="{{ old('url', $subitem->getUrl()) }}">
                                    {!! $errors->first('url', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                <label for="inputImage" class="col-sm-2 control-label">{{ trans('backend/menu_item.image') }} (246x100)</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="inputImage" name="image"
                                           placeholder="{{ trans('backend/menu_item.image') }}" value="{{ old('image') }}">
                                    {!! $errors->first('image', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('position') ? 'has-error' : '' }}">
                                <label for="inputPosition" class="col-sm-2 control-label">{{ trans('backend/menu_item.position') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputPosition" name="position" value="{{ old('position', $subitem->getPosition()) }}"
                                           placeholder="{{ trans('backend/menu_item.position') }}">
                                    {!! $errors->first('position', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('visible') ? 'has-error' : '' }}">
                                <label for="inputVisible" class="col-sm-2 control-label">{{ trans('backend/menu_item.visible') }}</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" class="checkbox" id="inputVisible" name="visible" {{ ($subitem->getVisible() ? 'checked' : '') }}>
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


                                        @foreach($subitem->getSubitems() as $subsubitem)
                                            <div id="subitem">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputTitle" class="col-sm-2 control-label">{{ trans('backend/menu_item.title') }}</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="inputTitle" name="sub_items_titles[]" required placeholder="{{ trans('backend/menu_item.title') }}" value="{{ $subsubitem->getTitle() }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="inputCategory" class="col-sm-2 control-label">{{ trans('backend/menu_item.category') }}</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control select2" name="sub_items_categories[]" id="inputCategory" style="width: 100%">
                                                            <option></option>
                                                            @foreach($categories as $category)
                                                                <option value="{{ $category->getId() }}" {{ (($subsubitem->getCategory() ? $subsubitem->getCategory()->getId() : '') == $category->getId() ? "selected" : "") }}>
                                                                    {{ $category->getName() }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="inputUrl" class="col-sm-2 control-label">{{ trans('backend/menu_item.url') }}</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="inputUrl" name="sub_items_urls[]"
                                                               placeholder="{{ trans('backend/menu_item.url') }}" value="{{ $subsubitem->getUrl() }}">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-sm-1">
                                                <button id="del" class="del btn btn-danger glyphicon glyphicon-remove row-remove" type="button"></button>
                                            </div>
                                            </div>
                                        @endforeach

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
            $('#subitems').append("<div id=\"subitem\">\n" +
                "\n" +
                "                                        <div class=\"col-sm-4\">\n" +
                "                                            <div class=\"form-group\">\n" +
                "                                                <label for=\"inputTitle\" class=\"col-sm-2 control-label\">{{ trans('backend/menu_item.title') }}</label>\n" +
                "                                                <div class=\"col-sm-10\">\n" +
                "                                                    <input type=\"text\" class=\"form-control\" id=\"inputTitle\" name=\"sub_items_titles[]\" required\n" +
                "                                                           placeholder=\"{{ trans('backend/menu_item.title') }}\" value=\"{{ old('title') }}\">\n" +
                "                                                </div>\n" +
                "                                            </div>\n" +
                "                                        </div>\n" +
                "\n" +
                "                                        <div class=\"col-sm-4\">\n" +
                "                                            <div class=\"form-group\">\n" +
                "                                                <label for=\"inputCategory\" class=\"col-sm-2 control-label\">{{ trans('backend/menu_item.category') }}</label>\n" +
                "                                                <div class=\"col-sm-10\">\n" +
                "                                                    <select class=\"form-control select2\" name=\"sub_items_categories[]\" id=\"inputCategory\" style=\"width: 100%\">\n" +
                "                                                        <option></option>\n" +
                "                                                        @foreach($categories as $category)\n" +
                "                                                            <option value=\"{{ $category->getId() }}\">\n" +
                "                                                                {{ $category->getName() }}\n" +
                "                                                            </option>\n" +
                "                                                        @endforeach\n" +
                "                                                    </select>\n" +
                "                                                </div>\n" +
                "                                            </div>\n" +
                "                                        </div>\n" +
                "\n" +
                "                                        <div class=\"col-sm-3\">\n" +
                "                                            <div class=\"form-group\">\n" +
                "                                                <label for=\"inputUrl\" class=\"col-sm-2 control-label\">{{ trans('backend/menu_item.url') }}</label>\n" +
                "                                                <div class=\"col-sm-10\">\n" +
                "                                                    <input type=\"text\" class=\"form-control\" id=\"inputUrl\" name=\"sub_items_urls[]\"\n" +
                "                                                           placeholder=\"{{ trans('backend/menu_item.url') }}\" value=\"{{ old('url') }}\">\n" +
                "                                                </div>\n" +
                "                                            </div>\n" +
                "                                        </div>\n" +
                "\n" +
                "                                        <div class=\"col-sm-1\">\n" +
                "                                            <button id=\"del\" class=\"del btn btn-danger glyphicon glyphicon-remove row-remove\" type=\"button\"></button>\n" +
                "                                        </div>\n" +
                "\n" +
                "                                        </div>");
            $('.del').on("click", function () {
                $(this).closest("#subitem").remove();
            });
        });


        $(document).ready(function () {
            $('.del').on("click", function () {
                $(this).closest("#subitem").remove();
            });
        });
    </script>
@endsection