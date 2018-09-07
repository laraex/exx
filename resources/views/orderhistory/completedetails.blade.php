@extends('layouts.app') 
@section('content')
<div class="container mt-40 mb-40">
  <div class="row">
		<h2>{{ trans('order.gift_details') }}</h2>
  </div>
  <div class="flex flex-gift-card-wrapper">
		  <div class="completeDetails">
    	<img class="card-img-top img-fluid" src="{{ url($completeDetails->giftcard->image) }}">
      	<div class="card-block">
        	<h4 class="card-title">{{ $completeDetails->giftcard->name }}</h4>
        	<p class="card-text">{{  $completeDetails->giftcard->description }}</p>
        </div>
    </div>
  </div>
</div>
@endsection