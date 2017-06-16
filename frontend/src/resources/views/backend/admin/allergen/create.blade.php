@extends('backend.layouts.app')

@section('header')
    <section class="content-header">
        <h1>
            {{ trans('texts.sections.allergens.title') }}
            <small>{{ trans('texts.sections.allergens.new') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i>  {{ trans('texts.sections.colors.title') }}</li>
            <li class="active">{{ trans('texts.sections.colors.new') }}</li>
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
                    <form role="form" class="form-horizontal" action="/management/allergen" method="POST">
                        <div class="box-body">
                            @include('backend.messages.session')

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">


                            @if ($allergen)
                                <input type="hidden" name="allergenId" value="{{$allergen->getId()}}">
                            @endif

                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.colors.name') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="name" value="{{$allergen ? $allergen->getName() : ''}}"
                                           placeholder="{{ trans('texts.sections.colors.name') }}" value="{{ old('name') }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="submit" class="btn btn-danger pull-right">{{ trans('buttons.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
