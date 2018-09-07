@extends('layouts.app')
@section('content')
<div class="container mt-20 mb-20">
<h1 class="page-title dark-text">{{ trans('myaccount.tradeorderhistory') }}</h1>
  @include('partials.message')

<div class="container bgd-box-round">
  <div class="col-md-12 mb-20 mt-20">
  <ul class="nav nav-pills justify-content-center">
  <li class="nav-item">
    <a class="nav-link {{ $status == 'holdcoin' ? 'active' : '' }}" href="{{ url('myaccount/tradehistory/show/holdcoin/all') }}">{{ trans('myaccount.holdcoin') }}</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ $status == 'transhistory' ? 'active' : '' }}" href="{{ url('myaccount/tradehistory/show/transhistory/all') }}">{{ trans('myaccount.transhistory') }}</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ $status == 'notconclude' ? 'active' : '' }}" href="{{ url('myaccount/tradehistory/show/notconclude/all') }}">{{ trans('myaccount.notconclude') }}</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ $status == 'deposit' ? 'active' : '' }}" href="{{ url('myaccount/tradehistory/show/deposit/pending') }}">{{ trans('myaccount.deposit') }}</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ $status == 'cryptowithdraw' ? 'active' : '' }}" href="{{ url('myaccount/tradehistory/show/cryptowithdraw/all') }}">{{ trans('myaccount.crypto_withdraw') }}</a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ $status == 'fiatwithdraw' ? 'active' : '' }}" href="{{ url('myaccount/tradehistory/show/fiatwithdraw/all') }}">{{ trans('myaccount.fiat_withdraw') }}</a>
  </li>
</ul>
  
     
  </div>
       <div class="col-md-12">
            @include('partials.message')
              @if ($status == 'holdcoin')
                  @include('trade.show_hold')
                    @endif
              @if ($status == 'transhistory')
                 @include('trade.show_transaction')
              @endif
               @if ($status == 'notconclude')
                  @include('trade.show_notconclude')
              @endif
              @if ($status == 'deposit')
                  @include('trade.show_deposit')
              @endif
              @if ($status == 'cryptowithdraw')
                  @include('trade.show_crypto_withdraw')
              @endif
               @if ($status == 'fiatwithdraw')
                  @include('trade.show_fiat_withdraw')
              @endif
            </div>
         
</div>
</div>
      @endsection
@push('bottomscripts')

<script>

function ChangeStatus(val){
alert(val);
  window.location.href ="/myaccount/tradehistory/show/transhistory/"+$val;
}
 $('[data-toggle="popover"]').popover({
        placement : 'top',
        trigger : 'hover'
    });

</script>

   

@endpush