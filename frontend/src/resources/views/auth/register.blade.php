@extends('frontend.layouts.app')

@section('content')

    <section class="main-container col1-layout">
        <div class="main container">
            <div class="account-login">
                <div class="page-title">
                    <h2>{{ trans('auth.create_an_account') }}</h2>
                </div>

                @include('backend.messages.session')

                <div class="col-1 new-users">
                        <div class="content">
                            <form class="form-list" role="form" method="POST" action="{{ route('register_customer') }}">
                                {{ csrf_field() }}

                                <div class="col-md-6 form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="first_name" class="control-label">{{ trans('auth.first_name') }}</label>

                                        <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>

                                        @if ($errors->has('first_name'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                        @endif
                                </div>

                                <div class="col-md-6 form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                    <label for="last_name" class="control-label">{{ trans('auth.last_name') }}</label>

                                    <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required autofocus>

                                    @if ($errors->has('last_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-md-12 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="control-label">{{ trans('auth.email') }}</label>

                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                </div>

                                <div class="col-md-6 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="control-label">{{ trans('auth.password') }}</label>

                                        <input id="password" type="password" class="form-control" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="password-confirm" class="control-label">{{ trans('auth.password_confirm') }}</label>

                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>

                                <div class="col-md-12">
                                    <p>*{{ trans('auth.terms_accept') }} <a href="{{ route('terms_and_conditions') }}">{{ trans('auth.terms_and_conditions') }}</a></p>
                                </div>

                                <div class="col-md-12 form-group">
                                        <button type="submit" class="button login">
                                            {{ trans('auth.register') }}
                                        </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    </div>
        </div>
    </section>
@endsection
