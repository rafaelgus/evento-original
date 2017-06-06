@extends('backend.layouts.auth')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <b>Evento</b>Original</div>
        <div class="login-box-body">

            @include('backend.messages.errors')

            <p class="login-box-msg">{{ trans('auth.log_in.title') }}</p>

            <form role="form" action="/management/login" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group has-feedback">
                    <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        <a href="{{ url('/admin-panel/password/reset') }}">{{ trans('auth.log_in.i_forgot_my_password') }}</a>
                    </div>
                    <div class="col-xs-4">
                        <button type="submit"
                                class="btn btn-primary btn-block btn-flat">{{ trans('auth.log_in.log_in') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('backend.auth.scripts')
@endsection
