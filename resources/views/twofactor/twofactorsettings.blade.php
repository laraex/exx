@extends('layouts.app')
@section('content')
<div class="flex container mt-40 mb-40">
    <div class="col col-md-3">
        @include('home.partials.settingsmenu')
    </div>
    <div class="col col-md-9 bgd-box-round p-20">
        <h1 class="page-title">{{ trans('forms.2fa_secret_key') }} </h1>
        <div class="panel panel-default">
            <div class="panel-body">
                @if (Auth::user()->google2fa_secret_status==1)
                    <a href="{{ url('/myaccount/2fa/disable') }}" class="btn btn-warning">{{ trans('forms.disable_2fa') }}</a>
                @else
                    <a href="{{ url('/myaccount/2fa/enable') }}" class="btn btn-primary">{{ trans('forms.enable_2fa') }}</a>
                @endif
            </div>

            <div class="panel-body mt-40">
            <a href="https://www.microsoft.com/en-us/store/p/authenticator-for-windows/9nblggh4n8mx" class="btn btn-info btn-sm" target="_blank">Download Google Authenticator(For Windows)</a><br><br>
            <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en&rdid=com.google.android.apps.authenticator2&pli=1" class="btn btn-info btn-sm" target="_blank">Download Google Authenticator(For Android)</a><br><br>
            <a href="https://support.google.com/accounts/answer/1066447?co=GENIE.Platform%3DiOS&hl=en&oco=1" class="btn btn-info btn-sm" target="_blank">Download Google Authenticator(For iOS)</a><br>
            </div>

        </div>
    </div>  
</div>
@endsection
