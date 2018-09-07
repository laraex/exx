@extends('layouts.app')
@section('content')
<div class="flex container mt-40 mb-40">
    <div class="col col-md-3">
        @include('home.partials.settingsmenu')
    </div>
    <div class="col col-md-9">
    <h1 class="page-title">{{ trans('forms.2fa') }}</h1>
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/myaccount/2fa/validate') }}">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('totp') ? ' has-error' : '' }}">
                        <label class="col-md-6 control-label">{{ trans('forms.one_time_password') }}</label>
                        <div class="col-md-6">
                            <input type="number" class="form-control" name="totp">
                            @if ($errors->has('totp'))
                            <span class="help-block">
                                <strong>{{ $errors->first('totp') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary" onclick="this.disabled=true;this.form.submit();">
                                {{ trans('forms.validate') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection