@extends('layouts.app') 
@section('content')
<div class="container">
    <h1 class="page-titlem mt-20 mb-20">{{ trans('myaccount.giftcard') }}</h1>
</div>
<div class="flex container mt-40 mb-40"> 
  <div class="col col-md-12">
      <div class="panel-body">
        @include('partials.message')
        <div class="row">
          <div class="container">
            <ul id="tab" class="nav nav-tabs" >
                <li class="nav-item"><a href="{{ url('myaccount/orderhistory/giftcard/approve') }}" class="nav-link {{ $status == 'approve' ? 'active' : '' }}" >{{ trans('myaccount.approve') }}</a></li>
                <li class="nav-item"><a href="{{ url('myaccount/orderhistory/giftcard/complete') }}" class="nav-link {{ $status == 'complete' ? 'active' : '' }}" >{{ trans('myaccount.complete') }}</a></li>
                <li class="nav-item"><a href="{{ url('myaccount/orderhistory/giftcard/wallet') }}" class="nav-link {{ $status == 'wallet' ? 'active' : '' }}" >{{ trans('myaccount.wallet') }}</a></li>
            </ul>
            <div class="row responsive">
              <div class="col-md-12">
                @if ($status == 'approve')
                   @include('orderhistory.giftcard_approve') 
                @elseif ($status == 'complete')
                   @include('orderhistory.giftcard_complete')
                @elseif ($status == 'wallet')
                   @include('orderhistory.giftcard_wallet')
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>  
@endsection
