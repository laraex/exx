@extends('layouts.welcome')
@push('headscripts')

@endpush
@section('banner')

@endsection
@section('content')
	<div class="container">
	<h1 class="text-center  mb-20 mt-40">
	{{ trans('welcome.topcryptoheading') }}</h1>
	<p>{{ trans('welcome.topcryptoleadtext') }} </p>
	<div class="flex-center">
		@include('tradingviewwidgets.marketdata')
	</div>
	</div>
@endsection 
