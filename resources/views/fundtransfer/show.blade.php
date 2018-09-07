
@extends('layouts.app')

@section('content')

<div class="flex container mt-40 mb-40">
        <div class="col col-md-3">
                  @include('fund.partials._sidebar_fund')
          </div>
        <div class="col col-md-9">
        <div class="panel-heading">{{ trans('myaccount.myfundtransfers') }}
   
          <!--  <a href="{{ url('myaccount/fundtransfer/send') }}" class="pull-right">{{ trans('myaccount.sendfundtransfer') }}</a> -->
        </div>
             
                <div class="panel-body">
                       @include('partials.message')
                      <div id="tab" class="btn-group" >
                          <a href="{{ url('myaccount/fundtransfer/type/send') }}" class="btn {{ $type == 'send' ? 'active' : '' }}" >{{ trans('myaccount.send') }}</a>
                          <a href="{{ url('myaccount/fundtransfer/type/received') }}" class="btn {{ $type == 'received' ? 'active' : '' }}" >{{ trans('myaccount.received') }}</a>                        
                    </div>
                    @include('fundtransfer.list')

                </div>
        </div>
      </div>
</div>
@endsection

