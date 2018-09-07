@extends('layouts.app')
@section('content')
<div class="container mt-20 mb-20">
<h1 class="page-title dark-text"> @if($status!='order')
{{ucfirst($status)}}
 @endif
{{ trans('myaccount.orderhistory') }}</h1>
  @include('partials.message')

 <div class="d-card mt-20 mb-20">

     @include('trade.show_partial_trade')
 
</div>
            
</div>
      @endsection
