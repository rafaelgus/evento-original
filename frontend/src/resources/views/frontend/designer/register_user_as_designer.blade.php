@extends('frontend.layouts.app')

@section('content')

    <section class="main-container col1-layout">
        <div class="main container">
            <div class="account-login">
                <div class="page-title">
                    <h2>{{ trans('designer.register.title') }}</h2>
                </div>

                <fieldset>
                    <div class="col-2 registered-users"><strong>{{ trans('designer.register.register_as_designer') }}</strong>
                        <div class="content">
                            <p>{{ trans('designer.register.benefits') }}</p>

                            <form class="form-list" role="form" method="POST" action="{{ route('designer.postRegister') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('nickname') ? ' has-error' : '' }}">
                                    <label for="nickname" class="control-label">{{ trans('designer.nickname') }}</label>

                                    <input id="nickname" type="text" class="form-control" name="nickname"
                                           value="{{ old('nickname') }}" placeholder="{{ trans('designer.nickname_placeholder') }}" required autofocus>

                                    @if ($errors->has('nickname'))
                                        <span class="help-block">
                                        <strong class="error">{{ $errors->first('nickname') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="button login">
                                        {{ trans('designer.register.continue') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </fieldset>

            </div>
        </div>
    </section>
@endsection
