@extends('layouts.app') 

@section('content')

<div class="flex container mt-40 mb-40">
          <div class="col col-md-3">
                  @include('fund.partials._sidebar_fund')
          </div>
        <div class="col col-md-9">
         <h1 class="page-title">{{ trans('forms.add_fund') }}</h1>
           <div class="row">

           <div class="col-md-10 col-md-offset-1">

            <p> {{ $instructions }}</p>


                <div class="well">
                    <p class="text-center">
                        <strong class="bitcoin-address"
                            data-bc-amount="{{ $btcamount }}"
                            data-bc-label="bitcoinaddress.js project"
                            data-bc-message="{{ $btcamount }} BTC For Deposit"
                            data-bc-address="{{ $params['address'] }}">{{ $params['address'] }}</strong>
                    </p>
                </div>


                  <div id="bitcoin-address-template" class="bitcoin-address-container" hidden>

                <div>
                    <b><span class="bitcoin-address"></span></b>
                </div>

                    <a href="#" class="bitcoin-address-action bitcoin-address-action-qr">
                    <i class="fa fa-qrcode"></i>
                    {{ trans('forms.qr_code') }}
                    </a>


                     <div class="bitcoin-action-hint bitcoin-action-hint-qr">
                    <p>
                        {{ trans('forms.bitcoin_direct_wallet_notes') }}
                    </p>

                     <p><b>
                           {{ trans('forms.total_send_amount') }} : {{ $btcamount  }} BTC
                      </b></p>
                    

                <div class="bitcoin-address-qr-container">
                    <!-- Filled in by JS on action click -->
                </div>
             </div>
             <br/>
               <form method="POST" action="{{ url('myaccount/fund/bitcoindirect') }}">  
                 {{ csrf_field() }}
                 <input name="amount" class="form-control" value="{{ $amount }}" type="hidden">
                 <input name="transaction_id" class="form-control" value="{{ $transaction_id }}" type="hidden">
                 <input name="btcamount" class="form-control" value="{{ $btcamount }}" type="hidden">
                 <input name="admin_address" class="form-control" value="{{ $params['address'] }}" type="hidden">

                  <input name="paymentgateway" class="form-control" value="{{ $paymentgateway }}" type="hidden">

                  <div class="form-group{{ $errors->has('txnhashkey') ? ' has-error' : '' }}">
                        <input name="txnhashkey" class="form-control" value="" type="text"  placeholder="Enter Hash Key Here" required="required">
                        <small class="text-danger">{{ $errors->first('txnhashkey') }}</small>
                    </div>

                  
                        <div class="form-group mt-20">    
                              <input value="{{ trans('forms.submit_complete_btn') }}" class="btn btn-success" type="submit" onclick="this.disabled=true;this.form.submit();">   
                                <a href="{{ url('myaccount/accounts') }}" class="btn btn-primary">{{ trans('forms.backtomywallet') }}</a>
                        </div>
                </form>
             </div>
        </div>
      </div>
    </div>
    </div>
  
@endsection
@push('bottomscripts')
<script src="{{ asset('js/bitcoinaddress.js') }}"></script>
@endpush