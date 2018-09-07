@extends('layouts.app')
@section('content')
<div class="flex container mt-40 mb-40">
    <div class="col col-md-3">
        @include('home.partials.settingsmenu')
    </div>
    <div class="col col-md-9">
    	<h1 class="page-title">{{ trans('forms.2fa_secret_key') }}</h1>
	    <div class="panel panel-default">
	        <div class="panel-body">
	            {{ trans('forms.2fa_removed') }}
	            <br /><br />
	            <a href="{{ url('/myaccount/twofactor') }}">{{ trans('forms.go_back_btn') }}</a>
	        </div>
	    </div>
	</div>
</div>
@endsection