@extends('layouts.app')

@section('content')

<div class="member-content">
    <div class="inner-wrapper login mt-40 mb-40">
        <div class="container">
            <div  class="flex flex-page-content">
                <div class="login-form-container bgd-box-round p-20">
                    @include('partials.message')
                        @if (\Config::get('settings.login_status') == 1)
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        <h1 class="page-title">{{ trans('auth.login') }}</h1>
                        {{ csrf_field() }}
                        @if (session('error'))
                            <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">{{ trans('auth.E-Mail-Address') }}</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">{{ trans('auth.password') }}</label>
                            <input id="password" type="password" class="form-control" name="password" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>{{ trans('auth.remember_me') }}</label>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{ trans('auth.login') }}
                            </button>

                            <a class="btn btn-link" href="{{ route('password.request') }}">
                               {{ trans('auth.forgot-password') }}
                            </a>
                        </div>
                    </form>
                    <hr>
                        @elseif (\Config::get('settings.login_status') == 0)
                            <p>{{ trans('forms.login_message') }}</p>
                        @endif
                    <p>{{ trans('auth.dont-have-account') }} <a href="{{ url('/register') }}">{{ trans('auth.signup') }}</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


