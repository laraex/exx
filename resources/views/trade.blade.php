@extends('layouts.trade')
@push('headscripts')
@endpush
@section('content')
<div class="main-section">
   <div class="container">
      <div class="flex flex-c">
         <div class="section-1 bgd-box-round flex">
              <input type="hidden" id="totoken" value="{{$totoken}}">
              <input type="hidden" id="fromtoken" value="{{$fromtoken}}">
              <input type="hidden" id="currentpair" value="{{$pairid}}">
               <trade-pair-select ></trade-pair-select>
         </div>
         <div class="grid gc-10 mt-20 mb-20" style="grid-template-columns: 1fr 3fr 1fr">
            <div class="grid-section-1  ">
               <div class="mb-20">
                <currency-pair></currency-pair>
              </div>
            </div>
           <div class="grid-section-2" style="display: flex; flex-direction: column;">
               <div class="mb-20" style="display: grid; grid-template-columns: 1fr 1fr; grid-column-gap: 10px;"> 
                  <mini-chart></mini-chart>
                  <trade></trade>
                </div>
                <div class="mb-20">
                  <currency-infor></currency-infor>
                </div>
           </div>
            <div class="grid-section-3">
               <trade-orders></trade-orders>
            </div>
      </div>
          
         </div>

      </div>
   </div>
   <!-- Popup Modal when first in website -->
   <div class="modal fade" id="visitor_modal" role="dialog" style="margin: 50px;">
      <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">{{ trans('popup.welcomeMessageTitle') }}</h4>
            </div>
            <div class="modal-body">
               <div class="panel-body">
                  <p>{!! trans('popup.welcomeMessageContent') !!}</p>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('welcome.close') }}</button>
            </div>
         </div>
      </div>
   </div>
   <!-- Popup Modal ends -->
</div>
@endsection
@push('bottomscripts')
@php
if (\Config::get('settings.welcomepopupstatus') == 1)
{
if (\Session::get('welcomepopupmessage') == '')
{
@endphp
<script>
   $(function() {
     $('#visitor_modal').modal('show');
   });
</script>
@endpush
@php
}
}
\Session::put('welcomepopupmessage', '1')
@endphp

