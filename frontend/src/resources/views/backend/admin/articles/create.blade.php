@extends('backend.layouts.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('texts.sections.article.title') }}
            <small>{{ trans('texts.sections.article.new') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i>  {{ trans('texts.sections.article.title') }}</li>
            <li class="active">{{ trans('texts.sections.article.new') }}</li>
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
                    <form role="form" class="form-horizontal" action="/management/articles" method="POST">
                        <div class="box-body">
                            @include('backend.messages.session')

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.name') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="name"
                                           placeholder="{{ trans('texts.sections.article.name') }}" value="{{ old('name') }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.description') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="description"
                                           placeholder="{{ trans('texts.sections.article.name') }}" value="{{ old('name') }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.barCode') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="barCode"
                                           placeholder="{{ trans('texts.sections.article.barCode') }}" value="{{ old('name') }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.internalCode') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="interalCode"
                                           placeholder="{{ trans('texts.sections.article.internalCode') }}" value="{{ old('name') }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.price') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputName" name="price"
                                           placeholder="{{ trans('texts.sections.article.price') }}" value="{{ old('name') }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.costPrice') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputName" name="costPrice"
                                           placeholder="{{ trans('texts.sections.article.costPrice') }}" value="{{ old('name') }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.ingredients') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="ingredients"
                                           placeholder="{{ trans('texts.sections.article.ingredients') }}" value="{{ old('name') }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.slug') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="slug"
                                           placeholder="{{ trans('texts.sections.article.slug') }}" value="{{ old('name') }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.categories') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control select2" id="categories" name="category"    ></select>
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.tags') }}</label>
                                <div class="col-sm-10">
                                    <select multiple class="form-control select2" id="tags" name="tags"
                                            placeholder="{{ trans('texts.sections.article.tags') }}" value="{{ old('name') }}"></select>
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.allergens') }}</label>
                                <div class="col-sm-10">
                                    <select multiple class="form-control select2" id="allergens" name="allergens"
                                            placeholder="{{ trans('texts.sections.article.allergens') }}" value="{{ old('name') }}"></select>
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.colors') }}</label>
                                <div class="col-sm-10">
                                    <select multiple class="form-control select2" id="colors" name="colors"
                                            placeholder="{{ trans('texts.sections.article.colors') }}" value="{{ old('name') }}"></select>
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.article.flavours') }}</label>
                                <div class="col-sm-10">
                                    <select multiple class="form-control select2" id="flavours" name="flavours"
                                            placeholder="{{ trans('texts.sections.article.flavours') }}" value="{{ old('name') }}" style="width: 100%"></select>
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
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
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section><!-- /.content -->
@endsection

@section('scripts_body')

<link href="/css/select2.min.css" rel="stylesheet" />
<script src="/js/select2.min.js"></script>


<script type="text/javascript">
    $('#categories').select2();
    $('#tags').select2();
    $('#allergens').select2();
    $('#colors').select2();
    $('#flavours').select2();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        context: this,
        url: '/management/category/getAll',
        type: 'GET'
    }).done(function (result) {
        $.each(result, function (i, option) {
            $('#categories').append($('<option>', {
                value: option.id,
                text: option.name
            }));
        });
    });

    $.ajax({
        context: this,
        url: '/management/tags/getAll',
        type: 'GET'
    }).done(function (result) {
        $.each(result, function (i, option) {
            $('#tags').append($('<option>', {
                value: option.id,
                text: option.name
            }));
        });
    });

    $.ajax({
        context: this,
        url: '/management/color/getAll',
        type: 'GET'
    }).done(function (result) {
        $.each(result, function (i, option) {
            $('#colors').append($('<option>', {
                value: option.id,
                text: option.name
            }));
        });
    });

    $.ajax({
        context: this,
        url: '/management/flavour/getAll',
        type: 'GET'
    }).done(function (result) {
        $.each(result, function (i, option) {
            $('#flavours').append($('<option>', {
                value: option.id,
                text: option.name
            }));
        });
    });

    $.ajax({
        context: this,
        url: '/management/allergen/getAll',
        type: 'GET'
    }).done(function (result) {
        $.each(result, function (i, option) {
            $('#allergens').append($('<option>', {
                value: option.id,
                text: option.name
            }));
        });
    });
</script>

@endsection