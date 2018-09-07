@extends('layouts.app') 
@section('content')
<div class="container mt-40 mb-40">
    <div class="row">
  		<h2>{{ trans('order.gift_details') }}</h2>
    </div>
    <div class="flex flex-gift-card-wrapper">
 		<div class="approveDetails">
          	<img class="card-img-top img-fluid" src="{{ url($approveDetails->giftcard->image) }}">
          	<div class="card-block">
            	<h4 class="card-title">{{ $approveDetails->giftcard->name }}</h4>
            	<p class="card-text">{{  $approveDetails->giftcard->description }}</p>
            </div>
        </div>
	</div>
</div>
@endsection