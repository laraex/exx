@extends('layouts.app')
@section('content')
<div class="container mb-40 mt-40">
    <h1 class="page-title">{{ trans('menu.dashboard') }}</h1>
      @include('partials.message')
<div class="grid grid-2 gc-20">
    <div class="widget-card">
            <h4><img src="{{ url($btc->image) }}" class="dashlet-flag">{{trans('myaccount.btc_details')}}</h4>

            @if(count($user_accounts)>0)

             {{-- <a  href="#" onclick="getwalletaddress('btc')">Your BTC Wallet Address</a> 
              <br> 
              <b id="btc_address"></b> --}}

              <p>{{$user_accounts->btc_address}}</p>
              @php 
                $decimal='%0.'.$btc->decimal.'f';
              @endphp

              <p>{{ trans('myaccount.balance')}} :<b> {{sprintf("$decimal",$balance)}} {{ $btc->token }} </b></p>
              <p  class="btc"><a href="{{url('myaccount/type/btc/send')}}" class="card-link btn btn-primary">{{trans('myaccount.send')}}</a> <a href="{{url('myaccount/type/btc/receive')}}" class="card-link btn btn-primary">{{trans('myaccount.receive')}}</a> 

              <a href="{{ url('myaccount/buy/setcoin/'.$btc->id) }}" class="card-link btn btn-primary">Buy {{$btc->displayname}}</a>
              </p>


            @else

              <p>  <a  href="#" class="card-link btn btn-primary btn-sm btcaddress">{{ trans('dashboard.btc_address')}}</a> </p>
              <p id="btcaddress"></p> 


            @endif


          <p style="display:none" class="btc"><a href="{{url('myaccount/type/btc/send')}}" class="card-link btn btn-primary">{{trans('myaccount.send')}}</a> <a href="{{url('myaccount/type/btc/receive')}}" class="card-link btn btn-primary">{{trans('myaccount.receive')}}</a> </p>
    </div>
    <div class="widget-card">
     
        <h4><img src="{{ url($ltc->image) }}" class="dashlet-flag">{{trans('myaccount.ltc_details')}}</h4>

        
            @if(count($user_accounts_ltc)>0)
              {{--<a  href="#" onclick="getwalletaddress('ltc')">Your LTC Wallet Address</a>
              <br>
              <b id="ltc_address"></b>--}}

             <p>{{$user_accounts_ltc->ltc_address}}</p>
              @php 
                $decimal='%0.'.$ltc->decimal.'f';
              @endphp

             <p>{{ trans('myaccount.balance')}} :<b> {{sprintf("$decimal",$balance_ltc)}} {{ $ltc->token }}</b></p>
              <p  class="ltc"> <a href="{{url('myaccount/type/ltc/send')}}" class="card-link btn btn-primary">{{trans('myaccount.send')}}</a> <a href="{{url('myaccount/type/ltc/receive')}}" class="card-link btn btn-primary">{{trans('myaccount.receive')}}</a> 
                <a href="{{ url('myaccount/buy/setcoin/'.$ltc->id) }}" class="card-link btn btn-primary">Buy {{$ltc->displayname}}</a>  
              </p>   

             @else

              <p>  <a  href="#" class="card-link btn btn-primary btn-sm ltcaddress">{{ trans('dashboard.ltc_address') }} </a> </p>
              <p id="ltcaddress"></p> 


            @endif

               <p style="display:none" class="ltc"> <a href="{{url('myaccount/type/ltc/send')}}" class="card-link btn btn-primary">{{trans('myaccount.send')}}</a> <a href="{{url('myaccount/type/ltc/receive')}}" class="card-link btn btn-primary">{{trans('myaccount.receive')}}</a> </p>                 
    </div>

</div>

<div class="grid grid-3 gc-20 mb-20 mt-20">
  @foreach ($walletlists as $walletlist)
    <div class="widget-card">
      <div class="flex flex-c-1">
        <p><img src="{{ url($walletlist->currency->image) }}" class="dashlet-flag"></p>
        <div>
          <p><span><strong>{{ $walletlist->currency->displayname }} {{ trans('myaccount.wallet') }}</strong></span><br/>
          <span><small>{{ $walletlist->account_no }}</small></span></p>
        </div>
      </div>
      <div class="flex-c-2">
        <div> 
          <table class="table table-striped table-condensed table-bordered">
              <tr>
                  <td width="55%">{{ trans('myaccount.availablebalance') }}</td>
                  <td> {{ $walletlist->currency->token }}
                      <span> {{ $walletlist->present()->getBalance($walletlist->currency->id, $walletlist->user_id) }}</span>
                  </td>
              </tr>                               
              @php
                  $pending=$walletlist->present()->getPendingBalance($walletlist->currency->id, $walletlist->user_id);
              @endphp
              @if($pending>0)
                  <tr>
                      <td>{{ trans('myaccount.pending') }}</td>
                      <td> <p>{{ $walletlist->currency->token }}
                          <span> {{ $pending }}</span></p>
                      </td>
                  </tr>
              @endif                                 
          </table>
        </div>
      </div>
    </div>
  @endforeach
</div>

<h3 class="page-title">{{trans('myaccount.ref_link')}}</h3>
<div class="grid grid-2 gc-20">
    <div class="widget-card grid-item">
      <a href="{{ url('/ref/') }}/{{ Auth::user()->name }}" target="_blank" class="refurl">
        {{ url('/ref') }}/{{ Auth::user()->name }}</a>
      <input type="button" id="copyurl" value="Copy" class="btn btn-sm btn-primary" onclick="copyToClipboard('.refurl')">
      <p><!-- Go to www.addthis.com/dashboard to customize your tools --> 
      <div class="addthis_inline_share_toolbox" data-url="{{ url('/ref') }}/{{ Auth::user()->name }}"></div></p>
    </div>

      @unless(is_null($sponsor))
      <div class="widget-card grid-item">
        <h3>{{trans('myaccount.sponsor_details')}}</h3>
        <p>{{$sponsor->name}}</p>
        <p>{{$sponsor->email}}</p>
     </div>
      @endunless
</div>

{{--<div class="d-card mt-20">
    <h4 class="d-card-title">{{ trans('myaccount.charts') }}</h4>
      @include('home.charts')
</div>--}}
                     
    <!--Modal-->
    <div class="modal fade" id="dashboard_modal" role="dialog" style="margin: 50px;">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">{{ trans('popup.dashboardMessageTitle') }}</h4>
              </div>
                    <div class="modal-body">                       
                        <div class="panel-body">
                            <p>{!! trans('popup.dashboardMessageContent') !!}</p>
                        </div>   
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('myaccount.close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@php
if (\Config::get('settings.dashboardpopupstatus') == 1)
{
    if (\Session::get('dashboardmessage') == '')
    {
    @endphp
    @push('bottomscripts')
    <script>
         $(function() {
           $('#dashboard_modal').modal('show');
        });
    </script>
    @endpush
    @php
    }   
}
\Session::put('dashboardmessage', '1')
@endphp

@push('bottomscripts')
<script>
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
/*function getwalletaddress(wallet){
    $.ajax(
        {
        url: "{{url('myaccount/getwalletaddress')}}", 
        data:{'wallet':wallet},
        method:'post',
        success: function(result){
            if(wallet=='btc')
           $("#btc_address").html(result);
           if(wallet=='ltc')
           $("#ltc_address").html(result); 
           if(wallet=='doge')
           $("#doge_address").html(result);
    }});
}*/
function copyToClipboard(element) {

    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
    $('#copyurl').val("Copied");
    $('#copyurl').addClass("copytext");
}
</script>

<script>
  $(document).ready(function(){
    $(".btcaddress").click(function(e){
        e.preventDefault();
      $.ajax({type: "POST",
              url: "{{url('myaccount/createwallet/btc')}}",            
              success:function(result){
                if(result!='')
                {
                  $("#btcaddress").html(result);
                  $(".btcaddress").css('display','none');
                  $(".btc").css('display','block');
                }
                else
                {
                   $("#btcaddress").html("Try After Sometime");
                }
      }});
    });
  });
</script>

<script>
  $(document).ready(function(){
    $(".ltcaddress").click(function(e){
        e.preventDefault();
      $.ajax({type: "POST",
              url: "{{url('myaccount/createwallet/ltc')}}",            
              success:function(result){

                if(result!='')
                {
                    $("#ltcaddress").html(result);
                    $(".ltcaddress").css('display','none');
                    $(".ltc").css('display','block');
                }
                else
                {
                     $("#ltcaddress").html("Try After Sometime");
                }
      }});
    });
  });
</script>

<script>
  $(document).ready(function(){
    $(".dogeaddress").click(function(e){
        e.preventDefault();
      $.ajax({type: "POST",
              url: "{{url('myaccount/createwallet/doge')}}",            
              success:function(result){

                if(result!='')
                {
                    $("#dogeaddress").html(result);
                    $(".dogeaddress").css('display','none');
                    $(".doge").css('display','block');
                }
                else
                {
                     $("#dogeaddress").html("Try After Sometime");
                }
      }});
    });
  });
</script>

@endpush

