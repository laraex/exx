@extends('layouts.welcome')

@section('content')
<div class="container mb-50 mt-50">
<h2 class="page-title">{{ trans('welcome.marketdataheading') }}</h2>
    <div class="mb-3">
        <div class="row">
            <div class="col">
                
             <form method="get" action="{{ url('market')}}" class="form-horizontal">
             

                <input type="text" id="cryptocurrency" placeholder="Search.." class="form-control"  name="search">
                <a href="{{ url('market')}}">{{ trans('market.reset') }}</a>
               </form>
            </div>
            @if(count($CryptoCurrency)>0)
                <div class="col">
                    {!! $CryptoCurrency->links('vendor.pagination.bootstrap-4') !!}
                </div>
            @endif
        </div>
    </div>
    <div class="card mb-3">
        <table class="table table-striped bg-white table-data mb-0 mt-0 table-sm" cellspacing="0" width="100%">
            <thead>
            <tr class="align-middle text-right">
                <th class="text-center">{{ trans('market.symbol') }}</th>
                <th class="text-left">{{ trans('market.name') }}</th>
                <th>{{ trans('market.cap') }}</th>
                <th>{{ trans('market.price') }}</th>
                <th>{{ trans('market.volume') }}</th>
                <th>{{ trans('market.supply') }}</th>
                <th>{{ trans('market.change') }}</th>
            </tr>
            </thead>
            <tbody>
            @if(count($CryptoCurrency)>0)
            @foreach($CryptoCurrency as $Currency)
                <tr class="align-middle text-right">
                    <td class="text-center font-weight-bold">{!! $Currency->rank !!}</td>
                    <td class="text-left">
                        <a class="currency-name d-flex align-items-stretch" href="#">
                            @unless(is_null($Currency->logo))
                                <span><img class="img-circle" src="{!! asset('images/32x32/'.$Currency->logo) !!}" alt="{!! strtolower($Currency->name) !!}" width="32" height="32" ></span>
                            @else
                                <span class="bg-dark py-1 px-2 rounded-circle ">{!! $Currency->symbol[0] !!}</span>
                            @endif
                            <span class="ml-2">
                                 <b class="d-inline-block">{!! $Currency->name !!}</b>
                                <small class="d-block text-dark">{!! $Currency->symbol !!}</small>
                            </span>
                        </a>
                    </td>
                    <td class="text-right">
                       <span class="dark-text"> ${!! number_format($Currency->market_cap_usd,0,',','.') !!}</span><br>
                        <small class="font-italic dark-text">{!! number_format($Currency->market_cap_usd / $globalData['BTC_price_usd'],0,',','.')  !!} BTC</small>
                    </td>
                    <td>
                        <a class="font-weight-bold d-block" href="#">
                            ${!! number_format($Currency->price_usd,2,',','.') !!}
                        </a>
                        <small class="font-italic dark-text">{!! number_format($Currency->price_btc,6,',','.') !!} BTC</small>
                    </td>
                    <td> <span class="dark-text">${!! number_format($Currency->available_supply,0) !!}</span></td>
                    <td><a target="_blank" rel="nofollow" href="{!! $Currency->circulating_url !!}">{!! number_format($Currency->available_supply).' '.$Currency->symbol !!}</a></td>
                    <td>
                        <span class="font-weight-bold {!! ($Currency->percent_change_24h < 0 ? 'text-danger' : 'text-success') !!}">
                            {!! number_format($Currency->percent_change_24h,2) !!}%
                            <i class="ml-1 icon icon-caret-{!! ($Currency->percent_change_24h < 0 ? 'down' : 'up') !!}" aria-hidden="true"></i>
                        </span>
                    </td>
                </tr>
            @endforeach
            @else
             <tr class="align-middle text-right">
                 <td class="text-center font-weight-bold">
                {{trans('welcome.norecords')}}
                </td>
                 <td class="text-center font-weight-bold"></td>
                  <td class="text-center font-weight-bold"></td>
                   <td class="text-center font-weight-bold"></td>
                    <td class="text-center font-weight-bold"></td>
                     <td class="text-center font-weight-bold"></td>
                      <td class="text-center font-weight-bold"></td>
             </tr>
            @endif
            </tbody>

        </table>

    </div>
@if(count($CryptoCurrency)>0)
    <div class="row">
        <div class="col">
           {{ trans('market.mineable') }} 
        </div>
        <div class="col">
            {!! $CryptoCurrency->links('vendor.pagination.bootstrap-4') !!}
        </div>
        <div class="col-12 text-center h3 mt-3">
            Total Market Cap: ${!! $globalData['sumCryptoCurrencies'] !!}
        </div>
    </div>
    <div>
        Last updated: {!! $Currency->updated_at->toDayDateTimeString() !!} UTC
    </div>
   
@endif
</div>
@endsection
