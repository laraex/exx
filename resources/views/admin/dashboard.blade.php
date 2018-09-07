@extends('backpack::layout')

@section('header')
    <section class="content-header">
      <h1> Dashboard </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
        <li class="active">{{ trans('admin_dashboard.dashboard') }}</li>
      </ol>
    </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="">
        <div class="row">
          <div class="col-sm-12">
            @include('partials.message')
          </div>
        </div>
        <div class="row" >
          <div class="col-md-12" >
            <div class=" col-md-6 ui-widget-content">
              <primarycoin-sales :keys="{{$registereduser->keys()}}" :values="{{$registereduser->values()}}" label="Users Registered for Last 10 Days" color="#f48f11" type="bar"></primarycoin-sales>
            </div>
            {{-- <div class=" col-md-4 ui-widget-content">
                  <primarycoin-sales :keys="{{$loggedinlist->keys()}}" :values="{{$loggedinlist->values()}}" label="Currently Logged Users" color="#f48f11" type="bar"></primarycoin-sales>
            </div> --}}
          </div>
        </div>
      <!--   <div class="row" >
          <div class="col-md-12" >
            <div class=" col-md-12 ui-widget-content">
              <p>{{ trans('admin_dashboard.fiat_currency') }}</p>
                          <fiat-exchange :keys = "{{$date_array->values()}}" :values = "{{$getcommissions->values()}}" label = "USD" type = "bar" :currency = "{{$currency}}" :currency_id = "{{ $currency_id }}"  ></fiat-exchange>
                        </div>
                      </div>
                    </div>

                    <div class="row" >
                      <div class="col-md-12" >
                        <div class=" col-md-12 ui-widget-content">
                        <p>{{ trans('admin_dashboard.member_balance') }}</p>
                          <primarycoin-sales :keys = "{{$totalamt->keys()}}" :values = "{{$totalamt->values()}}" label = "Member Balance" type = "bar" color="orange"></primarycoin-sales>
                        </div>
                      </div>
                    </div> -->

                   <div class="row" >
                  <div class="col-md-12" >
                        <div class="widget-groups" id="containment-wrapper">
                            @include('admin.partials.widget_pending_deposits')
                            @include('admin.partials.widget_pending_withdraws')
                            @include('admin.partials.widget_quick_message')
                            @include('admin.partials.widget_pending_kyc')
                            @include('admin.partials.widget_support_tickets')
                            @include('admin.partials.widget_recent_fundtransfers')
                            @include('admin.partials.widget_recent_signups')
                            @include('admin.partials.widget_recent_activity')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

        @include('admin.datatable')

        @push('dashboardscripts')
        <script>
            $(document).ready(function(){
                $('#userdatatable').DataTable();
            });
        </script>
            <style>
                       
              .wrapper
              {
                
                  cursor: move;
              }
            </style>
         <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
         <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
           <script>
          
            $("#containment-wrapper").sortable({ 
               cursor: "move",
               opacity: 0.5,
               stop : function(event, ui){  
                var sort=$(this).sortable('toArray');
               localStorage.sort = JSON.stringify(sort) ;

              
             
               }
            });

             var sort = localStorage.sort || "{}",
             sort = JSON.parse(sort);
             $.each(sort, function (id, pos) {

                $f=id-1;
                $last_pos=sort[$f];

                if(id>0)
                {               
                    $("#"+pos).insertAfter("#"+$last_pos);
                }

            });

            </script>



        @endpush

@push('dashboardscripts')
<script src="{{ asset('js/app.js') }}"></script> 
@endpush