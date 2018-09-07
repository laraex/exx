@extends('layouts.app')

@section('content')

<div class="flex container mt-40 mb-40">
          
        <div class="col col-md-9">
            <h1 class="page-title">Send LTC to External Wallet</h1>
                        <div class="panel-body">                  

                            <div class="row">
                               @include('partials.message')
                                  <div class="col-md-12">
                               @include('coin.ltc_send_form')
                               </div>
                            </div>                 
                 
                         </div>
       </div>
</div>
@endsection




