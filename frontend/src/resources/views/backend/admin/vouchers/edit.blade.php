@extends('backend.layouts.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('texts.sections.vouchers.title') }}
            <small>{{ trans('texts.sections.vouchers.edit') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i>  {{ trans('texts.sections.vouchers.title') }}</li>
            <li class="active">{{ trans('texts.sections.vouchers.new') }}</li>
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
                    <form role="form" class="form-horizontal" action="{{'/management/vouchers/'. $voucher->getId()}}" method="POST">
                        <div class="box-body">
                            @include('backend.messages.session')

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">

                            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.vouchers.code') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="code"
                                           placeholder="{{ trans('texts.sections.tags.code') }}" value="{{ old('code', $voucher->getCode()) }}">
                                    {!! $errors->first('code', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.vouchers.type') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{ $voucher->getType() }}" disabled>
                                    <input type="hidden" name="type" value="{{ $voucher->getType() }}">
                                    {!! $errors->first('amount', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            @if ($voucher->getValue())
                            <div class="form-group {{ $errors->has('value') ? 'has-error' : '' }}" id="valueForm">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.vouchers.value') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="value"
                                           placeholder="{{ trans('texts.sections.vouchers.code') }}" value="{{ old('value', $voucher->getValue()) }}">
                                    {!! $errors->first('value', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            @endif
                            @if ($voucher->getAmount())
                            <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}" id="amountForm">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.vouchers.amount') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="amount"
                                           placeholder="{{ trans('texts.sections.vouchers.amount') }}" value="{{ old('amount', $voucher->getAmount()) }}">
                                    {!! $errors->first('amount', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            @endif
                            <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.vouchers.type') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="inputName" name="category" {{($voucher->getCategory()) ? '' :'disabled'}}>
                                        @foreach($categories as $category)
                                            <option value="{{$category->getId()}}" {{(in_array($voucher, $category->getVouchers()->toArray())? 'selected' : '')}}>{{$category->getName()}}</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('amount', '<span class="help-block">* :message</span>') !!}
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

@section('scripts_body')

@endsection