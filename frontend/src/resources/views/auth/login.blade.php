@extends('frontend.layouts.app')

@section('content')

    <section class="main-container col1-layout">
        <div class="main container">
            <div class="account-login">
                <div class="page-title">
                    <h2>{{ trans('auth.log_in.title') }}</h2>
                </div>

                <fieldset class="col2-set">
                    <div class="col-1 new-users"><strong>{{ trans('auth.new_customers') }}</strong>
                        <div class="content">
                            <p>{{ trans('auth.new_customers_benefits') }}</p>
                            <div class="buttons-set">
                                <button onclick="window.location='/register';" class="button create-account" type="button"><span>{{ trans('auth.create_an_account') }}</span></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 registered-users"><strong>{{ trans('auth.registered_users') }}</strong>
                        <div class="content">
                            <p>{{ trans('auth.registered_users_message') }}</p>

                            <form class="form-list" role="form" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="control-label">E-Mail</label>

                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong class="error">{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="control-label">Password</label>

                                        <input id="password" type="password" class="form-control" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong class="error">{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                </div>

                                <div class="form-group">
                                        <button type="submit" class="button login">
                                            {{ trans('auth.log_in.log_in') }}
                                        </button>

                                        <a class="forgot-word" href="{{ route('password.request') }}">
                                            {{ trans('auth.log_in.i_forgot_my_password') }}
                                        </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </fieldset>

            </div>
        </div>
    </section>
@endsection
