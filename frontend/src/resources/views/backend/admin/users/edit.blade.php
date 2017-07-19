@extends('backend.layouts.app')

@section('header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ trans('texts.sections.users.title') }}
            <small>{{ trans('texts.sections.users.edit') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-tint"></i>  {{ trans('texts.sections.users.title') }}</li>
            <li class="active">{{ trans('texts.sections.users.edit') }}</li>
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
                    <form role="form" class="form-horizontal" action="{{ '/management/users/' . $user->getId() }} " method="POST">
                        <div class="box-body">
                            @include('backend.messages.session')

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">

                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.users.name') }}</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputName" name="name" placeholder="{{ trans('texts.sections.users.name') }}" value="{{ old('name', $user->getName()) }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.users.password') }}</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="inputName" name="password" placeholder="{{ trans('texts.sections.users.password') }}" value="{{ old('password') }}">
                                    {!! $errors->first('name', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('confirm') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.users.password') }}</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="inputName" name="confirm" placeholder="{{ trans('texts.sections.users.password') }}">
                                    {!! $errors->first('confirm', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                <label for="inputName" class="col-sm-2 control-label">{{ trans('texts.sections.users.email') }}</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="inputName" name="email" value="{{ old('email', $user->getEmail()) }}">
                                    {!! $errors->first('email', '<span class="help-block">* :message</span>') !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <div class="form-group {{ $errors->has('roles[]') ? 'has-error' : '' }}" id="checkbox">

                                    </div>
                                    {!! $errors->first('roles[]', '<span class="help-block">* :message</span>') !!}
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
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });

        $.ajax({
            content: this,
            url : '/management/users/roles',
            type: 'GET'
        }).done(function(result) {
            $.each(result.roles, function (i, option) {
                $('#checkbox').append(
                    '<div class="checkbox">' +
                    '<label>' +
                    '<input type="checkbox" value="'+ option.id +'" name="roles[]">' +
                    option.name +
                    '</label>'+
                    '</div>'
                );
            })
        });
    </script>
@endsection