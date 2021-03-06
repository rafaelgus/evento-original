@extends('backend.layouts.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('texts.sections.categories.title') }}
            <small>{{ trans('texts.sections.categories.edit') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i>  {{ trans('texts.sections.categories.title') }}</li>
            <li class="active">{{ trans('texts.sections.categories.edit') }}</li>
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
                    <form role="form" class="form-horizontal" action="{{ '/management/category/' . $category->getId() }}" method="POST">
                        <div class="box-body">
                            @include('backend.messages.session')

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">

                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.categories.name') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="name"
                                           placeholder="{{ trans('texts.sections.categories.name') }}" value="{{ old('name', $category->getName()) }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                <label for="inputSlug" class="col-sm-2 control-label">{{ trans('texts.sections.categories.slug') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputSlug" name="slug"
                                           placeholder="{{ trans('texts.sections.categories.slug') }}" value="{{ old('slug', $category->getSlug()) }}">
                                    {!! $errors->first('slug', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                <label for="inputDescription"
                                       class="col-sm-2 control-label">{{ trans('texts.sections.categories.description') }}</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="inputDescription" name="description" rows="5"
                                              placeholder="{{ trans('texts.sections.categories.description') }}">{{ old('description', $category->getDescription()) }}</textarea>
                                    {!! $errors->first('description', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('affiliate_commission') ? 'has-error' : '' }}">
                                <label for="inputAffiliateCommission"
                                       class="col-sm-2 control-label">{{ trans('texts.sections.categories.affiliate_commission') }}</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="inputAffiliateCommission" name="affiliate_commission" value="{{ old('affiliate_commission', $category->getAffiliateCommission()) }}"
                                           placeholder="{{ trans('texts.sections.categories.affiliate_commission') }}">
                                    <input type="checkbox" name="apply_commission_to_children"> Aplicar misma comisión a categorías hijas
                                    {!! $errors->first('affiliate_commission', '<span class="help-block">* :message</span>') !!}
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
