@extends('layouts.welcome')
@push('headscripts')

@endpush
@section('banner')

@endsection
@section('content')
	<div class="container">
	<h1 class="text-center  mb-20 mt-40">
	{{ trans('welcome.cryptochartheading') }}</h1>
	<p>{{ trans('welcome.cryptochartleadtext') }} </p>
		<div class=" flex-center">
			@include('tradingviewwidgets.chart-btc-ltc-eth')
		</div>
</div>
@endsection 
