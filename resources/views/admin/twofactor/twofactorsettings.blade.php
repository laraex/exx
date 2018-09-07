@extends('layouts.app')
@section('content')
<div class="flex container mt-40 mb-40">
    <div class="col col-md-3">
        @include('home.partials.settingsmenu')
    </div>
    <div class="col col-md-9">
        <h1 class="page-title">{{ trans('forms.2fa_secret_key') }} </h1>
        <div class="panel panel-default">
            <div class="panel-body">
                @if (Auth::user()->google2fa_secret)
                    <a href="{{ url('/myaccount/2fa/disable') }}" class="btn btn-warning">{{ trans('forms.disable_2fa') }}</a>
                @else
                    <a href="{{ url('/myaccount/2fa/enable') }}" class="btn btn-primary">{{ trans('forms.enable_2fa') }}</a>
                @endif
            </div>
        </div>
    </div>  
</div>
@endsection
