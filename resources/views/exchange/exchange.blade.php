@extends('layouts.app')
@section('content')
<div class="container">
<div class="col-md-12 mb-20 mt-20">
<ul class="nav justify-content-center nav-tabs">
  <li class="nav-item">
    <a href="{{url('/myaccount/externalexchange/create')}}" class="nav-link">{{trans('myaccount.switch_to_externalexchange')}}</a>
  </li>
  <li class="nav-item">
   <a href="{{url('/myaccount/exchange')}}" class="nav-link active">{{trans('myaccount.switch_to_exchange')}}</a>
  </li>
</ul> 
</div>


<h1 class="page-title">{{ trans('exchange.currency_exchange') }}</h1>

<div class="grid grid-300-auto mb-40 mt-20">
    <div class="grid-item widget-card">
        @include('exchange.partials.rate_table')
    </div>
    <div class="grid-item widget-card">
        @include('exchange.partials.exchange_form')
    </div>
</div>
</div>
@endsection