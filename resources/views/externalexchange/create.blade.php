@extends('layouts.app')
@section('content')
<div class="container">
<div class="col-md-12 mb-20 mt-20">
<ul class="nav justify-content-center nav-tabs">
  <li class="nav-item">
    <a href="{{url('/myaccount/externalexchange/create')}}" class="nav-link active">{{trans('myaccount.switch_to_externalexchange')}}</a>
  </li>
  <li class="nav-item">
   <a href="{{url('/myaccount/exchange')}}" class="nav-link">{{trans('myaccount.switch_to_exchange')}}</a>
  </li>
</ul> 
</div>
<div class="grid grid-8 gc-10">
@foreach($list as $pair)
  <a href="{{url('myaccount/externalexchange/pair/'.$pair->id)}}" class="btn btn-info">{{ $pair->fromcurrency->token }}-{{ $pair->tocurrency->token }}<br>{{ number_format((float)$pair->present()->getExternalExchange(1, $pair->tocurrency->name,$pair->fromcurrency->name ,'buy',$pair->exchange_rate_variant),3) }}</a>
@endforeach
</div>
<div class=""> 
  @if($total_amount>0)
  <h4 class="mb-20 mt-20">{{ trans('forms.exchange_pair_title',['from'=>$pair_details->fromcurrency->name,'to'=>$pair_details->tocurrency->name]) }}</h4>
  @include('partials.message')
  <div class="col-md-12 mb-20 mt-20">
    @include('externalexchange.create_form')
  </div>
  @else
    {{trans('myaccount.nocurrencypair')}}
  @endif

@include('externalexchange.show_transaction')
</div>
</div>
@endsection


