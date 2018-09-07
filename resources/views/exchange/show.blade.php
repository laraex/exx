@extends('layouts.app')

@section('content')
 <div class="container">
  @include('transaction._tabs')
  </div> 
    <div class="member-content">
            <div class="inner-wrapper accounts mt-40 mb-40">
            @include('partials.message')
                    <div class="container">
                      <div class="flex flex-page-head">
                          <div class="flex flex-page-left">
                            <h1 class="page-title">{{trans('forms.exchange_transactions')}}</h1>
                          </div>
                                   
                            
                            </div>
                            <div  class="flex flex-page-content">
                            <div class="row">
                            <div class="col-md-12">
                               
                                  @include('exchange.show_list')
                              
                                   </div>
                                   </div>
                            </div>
                    </div>
            </div>
    </div>
@endsection