@extends('layouts.app')
@section('content')
<div class="container">
               	<div class="row">
                    <div class="col-md-12 mt-20" >
   
               		<div class="col-md-12 mt-20" style="height:90px;margin-top:20px;
                  background-color:#ccc;">
               			<form name="form">
               				{{ csrf_field() }}
               			<select name="payment" id="coin" onchange="gettradeTotal(this.value);">
			  @foreach($currencylist as $pair)
			  <option value="{{$pair->id}}" {{(session('currencypair')==$pair->id?"selected":"") }}>{{ $pair->fromcurrency->token }}-{{ $pair->tocurrency->token }}</option>
			 <!--  <a href="{{url('myaccount/externalexchange/pair/'.$pair->id)}}" class="btn btn-info">{{ $pair->fromcurrency->token }}-{{ $pair->tocurrency->token }}<br>{{ number_format((float)$pair->present()->getExternalExchange(1, $pair->tocurrency->name,$pair->fromcurrency->name ,'buy',$pair->exchange_rate_variant),3) }}</a> -->
			        @endforeach		
               				<!-- <option value="1-4">BTC-USD</option>
               				<option value="1-5">BTC-GBP</option>
               				<option value="1-6">BTC-EUR</option>
               				<option value="1-7">BTC-NGN</option>
               				<option value="2-4">LTC-USD</option>
               				<option value="2-5">LTC-GBP</option>
               				<option value="2-6">LTC-EUR</option>
               				<option value="2-7">LTC-NGN</option>
               				<option value="8-4">DOGE-USD</option>
               				<option value="8-5">DOGE-GBP</option>
               				<option value="8-6">DOGE-EUR</option>
               				<option value="8-7">DOGE-NGN</option> -->
            			</select>

               			<div>1 <span id="tocurr"></span> <span id="order_amount"></span> <span id="fromcurr"></span> 
                
               			</div>
               		</form>
               		</div>
               	</div>
<chartbtc-usd></chartbtc-usd>
                               <!-- TradingView Widget BEGIN -->
<!-- <div class="tradingview-widget-container">
  <div id="tv-medium-widget"></div>
  <div class="tradingview-widget-copyright"><a href="https://in.tradingview.com/symbols/COINBASE-BTCUSD/" rel="noopener" target="_blank">
   </a>    </div>

 </div> -->
<!-- TradingView Widget END -->
                </div>
   </div>
<!-- <p>{{session('currencypair')}}</p> -->
<div class="flex flex-m" style="justify-content: space-between;">
<h1 class="page-title mb-20 dark-text">(<span id="currency_name"></span>) 
</h1> <h2>{{trans('forms.buy_heading')}} </h2>
<div class="grid grid-4 gc-20">
  <div>
    <div>Current</div>
    <div><span id="latest_order"> </span></div>
  </div>
  <div>
   <div> High</div> 
    <div><span id="max_order"></span></div> 
  </div>
  <div>
  <div> Low </div>
  <div><span id="min_order"></span></div>
  </div>
  <!-- <div>
  <div> Volume </div>
  <div> <span id="sell_total_amount"></span></div>
  </div> --> 
</div>

</div>

<!-- <h1 class="page-title mb-20 dark-text">{{trans('forms.buy_heading')}}</h1> -->
<!-- <buysell></buysell> -->

<div class="d-card">

<div id="BTC-USD">
<trade></trade>

</div>
<div id="BTC-GBP" >
<tradebtc-gbp></tradebtc-gbp>
</div>
<div id="BTC-EUR" >
<tradebtc-eur></tradebtc-eur>
</div>

<div id="LTC-USD" >
<tradeltc-usd></tradeltc-usd>
</div>
<div id="LTC-GBP" >
<tradeltc-gbp></tradeltc-gbp>
</div>
<div id="LTC-EUR" >
<tradeltc-eur></tradeltc-eur>
</div>

<!-- 
<div id="BTC-USD">
<trade></trade>
</div> -->

<!-- <div id="DOGE-USD" >
<tradedt-usd></tradedt-usd>
</div>
<div id="DOGE-GBP" >
<tradedt-gbp></tradedt-gbp>
</div>
<div id="DOGE-EUR">
<tradedt-eur></tradedt-eur>
</div> -->

                @include('partials.message')
                                  
               <div class="container">
               	<div class="row">
               		<!-- <div class="col-md-12"> -->
					<div class="col-md-6">
						<div class="grid-form-item">
							<h4>{{trans('forms.trade_buy_title')}}</h4>
							@include('trade.buy_form')
						</div>
						</div>
						<div class="col-md-6">
						<div class="grid-form-item">
							<h4>{{trans('forms.trade_sell_title')}}</h4>
							@include('trade.sell_form')
						</div>
					
                        <!-- </div> -->
                    </div>
				</div>
	
				</div>
</div>
@endsection
@push('bottomscripts')
<script type="text/javascript">
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
</script>

<script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
  <script type="text/javascript">
   
  new TradingView.MediumWidget(
  {
  "container_id": "tv-medium-widget",
  "symbols": [
    [
      "Chart",
      "COINBASE:BTCUSD|1y"
    ]
  ],
  "greyText": "Quotes by",
  "gridLineColor": "#e9e9ea",
  "fontColor": "#83888D",
  "underLineColor": "#dbeffb",
  "trendLineColor": "#4bafe9",
  "width": "1000px",
  "height": "400px",
  "locale": "in"
}
  );
  </script>

@if(session('currencypair')!='')
<script type="text/javascript">
//gettradeTotal('{{session('currencypair')}}');
 
   </script> 
<script type="text/javascript">
 $(document).ready(function() {
   gettradeTotal('{{session('currencypair')}}');
  var amount =1;
    
    var currency ={{session('currencypair')}}
    $('#BTC-USD').hide();
    $('#BTC-GBP').hide();
    $('#BTC-EUR').hide();
    $('#LTC-USD').hide();
    $('#LTC-GBP').hide();
    $('#LTC-EUR').hide();
    // $('#DOGE-USD').hide();
    // $('#DOGE-GBP').hide();
    // $('#DOGE-EUR').hide();

    if(amount>0){
        $.post("buy/exchangerates", { amount:amount, currency: currency, })
          .done(function( data ) {
           var res= $.parseJSON(data);
            //alert(res);
            $('#order_amount').html(res.convertamt);
            $('#scurrency_pair').val(currency);
            $('.fromcurrency').html(res.fromcurr);
            $('.tocurrency').html(res.tocurr);
            $('#fromcur').val(res.fromcurr);
            $('#tocur').val(res.tocurr);
            $('#userbalance').html(res.userbalance);
            $('#currency_pair').val(currency);
            $('#fromcurid').val(res.fromcurrid);
            $('#tocurid').val(res.tocurrid);
             $('#fromcurr').html(res.fromcurr);
            $('#tocurr').html(res.tocurr);
            $('#sfromcur').val(res.fromcurr);
            $('#stocur').val(res.tocurr);
            $('#suserbalance').html(res.userbalance);
           // $('#scurrency_pair').val(currency);
            $('#sfromcurid').val(res.fromcurrid);
            $('#stocurid').val(res.tocurrid);
            $('#sellerbalance').html(res.sellerbalance);

            

            var fromcur=res.fromcurr;
            var tocur=res.tocurr;
             var curpair=tocur+'-'+fromcur;
            $('#'+curpair).show();


           });

          

    }
});
</script>
@else
 
<script type="text/javascript">
$(document).ready(function() {
  
  gettradeTotal('1');

    var amount =1;
    var currency =1;
    $('#BTC-USD').hide();
    $('#BTC-GBP').hide();
    $('#BTC-EUR').hide();
    $('#LTC-USD').hide();
    $('#LTC-GBP').hide();
    $('#LTC-EUR').hide();
    // $('#DOGE-USD').hide();
    // $('#DOGE-GBP').hide();
    // $('#DOGE-EUR').hide();
    

    if(amount>0){
        $.post("buy/exchangerates", { amount:amount, currency: currency, })
          .done(function( data ) {
           var res= $.parseJSON(data);
          	//alert(res);
             $('#scurrency_pair').val(currency);
            $('#order_amount').html(res.convertamt);
            $('#fromcurr').html(res.fromcurr);
            $('#tocurr').html(res.tocurr);
            $('.fromcurrency').html(res.fromcurr);
            $('.tocurrency').html(res.tocurr);
            $('#fromcur').val(res.fromcurr);
            $('#tocur').val(res.tocurr);
            $('#userbalance').html(res.userbalance);
            $('#currency_pair').val(currency);
            $('#fromcurid').val(res.fromcurrid);
            $('#tocurid').val(res.tocurrid);
              
            $('#sfromcur').val(res.fromcurr);
            $('#stocur').val(res.tocurr);
            $('#suserbalance').html(res.userbalance);
           // $('#scurrency_pair').val(currency);
            $('#sfromcurid').val(res.fromcurrid);
            $('#stocurid').val(res.tocurrid);
            $('#sellerbalance').html(res.sellerbalance);


            var fromcur=res.fromcurr;
            var tocur=res.tocurr;
             var curpair=tocur+'-'+fromcur;
            $('#'+curpair).show();


           });

    }



});
</script>
@endif




<script type="text/javascript">

 function gettradeTotal(curval){
    //alert(curval);
   $.post("trade/totaltrade", {currency:curval })
          .done(function( data ) {
           var res= $.parseJSON(data);
            //alert(data.max_order);
           $('#max_order').html(res.max_order);
           $('#min_order').html(res.min_order);
           $('#latest_order').html(res.latest_order);
           $('#sell_total_amount').html(res.sell_total_amount);
           $('#currency_name').html(res.currency_name);

           });
 }
 function additionalData(){
      alert("JJss");
 }

$("#coin").on("change", function(){
  alert("JJ");
  //alert($('#coin').val());
  var curval=$('#coin').val();
  //alert(result[1]);
    var amount =1;
   // alert(result);
   // var fromcurrency =result[1];
    //var tocurrency =result[0];

    $('#BTC-USD').hide();
    $('#BTC-GBP').hide();
    $('#BTC-EUR').hide();
     $('#LTC-USD').hide();
    $('#LTC-GBP').hide();
    $('#LTC-EUR').hide();
    $('#DOGE-USD').hide();
    $('#DOGE-GBP').hide();
    $('#DOGE-EUR').hide();

    
    if(amount>0){
        $.post("buy/exchangerates", { amount:amount, currency:curval })
          .done(function( data ) {
           var res= $.parseJSON(data);
          	//alert(res);
             $('#sellerbalance').html(res.sellerbalance);
            $('#order_amount').html(res.convertamt);
            $('#fromcurr').html(res.fromcurr);
            $('#tocurr').html(res.tocurr);
            $('#fromcur').val(res.fromcurr);
            $('#tocur').val(res.tocurr);
            $('#fromcurid').val(res.fromcurrid);
            $('#tocurid').val(res.tocurrid);
            $('.fromcurrency').html(res.fromcurr);
            $('.tocurrency').html(res.tocurr);
            $('#userbalance').html(res.userbalance);
            $('#currency_pair').val(curval);


              var fromcur=res.fromcurr;
            var tocur=res.tocurr;

             var curpair=tocur+'-'+fromcur;

             $('#'+curpair).show();

             // if(curpair=="BTC-USD"){
             // $('#'+curpair).show();
                
             //    $('#BTC-GBP').hide();
             //    $('#BTC-EUR').hide();
             //  }
             //  else if(curpair=="BTC-GBP"){
            
             //  $('#BTC-GBP').show();
               
             //    $('#BTC-USD').hide();
             //    $('#BTC-EUR').hide();
             //  }
             //   else if(curpair=="BTC-EUR"){
            
             //    $('#BTC-EUR').show();
               
             //    $('#BTC-USD').hide();
             //    $('#BTC-GBP').hide();
             //  }

             //alert(curpair);

            
            $('.sfromcurrency').html(res.fromcurr);
            $('.stocurrency').html(res.tocurr);
            $('#sfromcur').val(res.fromcurr);
            $('#stocur').val(res.tocurr);
            //$('#suserbalance').html(res.userbalance);
            $('#scurrency_pair').val(curval);
            $('#sfromcurid').val(res.fromcurrid);
            $('#stocurid').val(res.tocurrid);

           });

     
          //window.location="/myaccount/trade";
    }

});
</script>
@endpush