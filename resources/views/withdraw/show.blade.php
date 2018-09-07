@extends('layouts.app') 
@section('content')

<div class="flex container mt-40 mb-40"> 
 <div class="col col-md-3">
                  @include('fund.partials._sidebar_fund')
          </div>
        <div class="col col-md-9">
        <div class="panel-heading">{{ trans('myaccount.mywithdraws') }}
   
          <!--  <a href="{{ url('myaccount/fundtransfer/send') }}" class="pull-right">{{ trans('myaccount.sendfundtransfer') }}</a> -->
        </div>
        <div class="panel-body">
                 @include('partials.message')
         <div class="row">
            <div class="container">
             <div id="tab" class="btn-group" >
             
              <a href="{{ url('myaccount/withdraw/pending') }}" class="btn {{ $status == 'pending' ? 'active' : '' }}" >{{ trans('myaccount.pending') }}</a>
              <a href="{{ url('myaccount/withdraw/completed') }}" class="btn {{ $status == 'completed' ? 'active' : '' }}" >{{ trans('myaccount.completed') }}</a>
              <a href="{{ url('myaccount/withdraw/rejected') }}" class="btn {{ $status == 'rejected' ? 'active' : '' }}" >{{ trans('myaccount.rejected') }}</a>
            </div>
                @if ($status == 'pending')
                    @include('withdraw.pending') 
                @elseif ($status == 'completed')
                    @include('withdraw.completed')
                @elseif ($status == 'rejected')
                    @include('withdraw.rejected')
                @endif
             </div>
        </div>
      </div>
</div>
   
@endsection
