@extends('layouts.app')
@section('content')
<div class="flex container mt-40 mb-40">
<div class="col col-md-9">
            <h1 class="page-title">{{ trans('forms.buy_coin_title',['coin'=>$currencydetails->name]) }}</h1>
                        <div class="panel-body">                  

                            <div class="row">
                               @include('partials.message')
                               @include('buycoin.coin_buy_coin_form')
                            </div>                 
                         </div>
       </div>
</div>
@endsection