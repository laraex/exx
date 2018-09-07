@extends('layouts.app')

@section('content')

<div class="flex container mt-40 mb-40">
          <div class="col col-md-3">
                  @include('sellcoin._sidebar_coin')
          </div>
        <div class="col col-md-9">
            <h1 class="page-title">{{ trans('forms.sell_coin_title',['coin'=>$currencydetails->displayname]) }}</h1>
                        <div class="panel-body">                  

                            <div class="row">
                               @include('partials.message')
                               @include('sellcoin.sell_coin_form')
                            </div>                 
                 
                         </div>
       </div>
</div>
@endsection