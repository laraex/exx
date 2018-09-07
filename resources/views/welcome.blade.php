@extends('layouts.welcome')
@push('headscripts')

@endpush
@section('banner')

     <div class="row-fluid">
        @include('welcome.banner')
    </div>

@endsection
@section('content')


<div class="welcome">
    <div class="row-fluid ">
        <div id="ticker-blue">
            <div class="container">
                <currency-pair-ticker></currency-pair-ticker>
                   {{--  @include('welcome.tickerbar') 
                    @foreach($fromcurrency as $fromcurrencies)
                        <div class="btn btn-info">
                            {{ $fromcurrencies->fromcurrency->token }}
                                @foreach($tocurrency as $tocurrencies)<br>
                                    {{ $tocurrencies->tocurrency->token }} {{ number_format((float)$tocurrencies->present()->getExternalExchange(1, $tocurrencies->tocurrency->name,$fromcurrencies->fromcurrency->name ,'buy',$tocurrencies->exchange_rate_variant),3) }}
                                @endforeach
                        </div>
                    @endforeach--}}
            </div>
        </div>
    </div>

    <div class="row-fluid">
        @include('welcome.ctabar')
    </div> 

    <div class="row-fluid">
        @include('welcome.maincontent')
    </div>
    
    @if(\Config::get('settings.livefeed_status') == 1)
        <div class="row-fluid" id="livefeed">
            <div class="container">        
                <livefeed></livefeed>
            </div>
        </div>
    @endif
    {{--<div class="row-fluid market-section">
        @include('welcome.marketwatch')
    </div>--}}

    <div class="row-fluid">
        @include('welcome.prpartner')
    </div>

    <div class="row-fluid">
        @include('welcome.helpbar')
    </div>
    <!-- <div id="screen"></div> -->

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
</div><!-- Popup Modal ends -->

</div>
@endsection



@php
if (\Config::get('settings.welcomepopupstatus') == 1)
{
    if (\Session::get('welcomepopupmessage') == '')
    {
    @endphp
    @push('bottomscripts')
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