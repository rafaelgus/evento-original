@extends('backend.layouts.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('texts.sections.vouchers.title') }}
            <small>{{ trans('texts.sections.vouchers.new') }}</small>
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
                    <form role="form" class="form-horizontal" onload="changeSelectType()" action="/management/vouchers" method="POST">
                        <div class="box-body">
                            @include('backend.messages.session')

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.vouchers.code') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="code"
                                           placeholder="{{ trans('texts.sections.vouchers.code') }}" value="{{ old('code') }}">
                                    {!! $errors->first('code', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.vouchers.type') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control" onchange="changeSelectType()" id="inputType" name="type">
                                        <option value="absoluto">Absoluto</option>
                                        <option value="relativo">Relativo</option>
                                    </select>
                                    {!! $errors->first('amount', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('value') ? 'has-error' : '' }}" id="valueForm" style="display: none;">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.vouchers.value') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="value"
                                           placeholder="{{ trans('texts.sections.vouchers.value') }}" value="{{ old('value') }}">
                                    {!! $errors->first('value', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('amount') ? 'has-error' : '' }}" id="amountForm">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.vouchers.amount') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="amount"
                                           placeholder="{{ trans('texts.sections.vouchers.amount') }}" value="{{ old('amount') }}">
                                    {!! $errors->first('amount', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">Categoria?</label>
                                <div class="col-sm-10">
                                    <input type="checkbox" id="hasCategory" onchange="changeCheckBox()">
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.vouchers.type') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="category" name="category" disabled>
                                        @foreach($categories as $category)
                                            <option value="{{$category->getId()}}">{{$category->getName()}}</option>
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
    <script type="text/javascript">
        function changeSelectType() {
            var type = document.getElementById('inputType').value;

            var formValue = document.getElementById('valueForm');
            var formAmount = document.getElementById('amountForm');

            if (type === "absoluto") {
                formValue.style.display = 'none';
                formAmount.style.display = 'block';
            } else {
                formValue.style.display = 'block';
                formAmount.style.display = 'none';
            }
        }
        
        function changeCheckBox() {
            var checked = document.getElementById('hasCategory').checked;

            if (checked) {
                document.getElementById('category').disabled = false;
            } else {
                document.getElementById('category').disabled = true;
            }
        }
    </script>
@endsection