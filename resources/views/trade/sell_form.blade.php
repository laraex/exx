<form method="post" action="{{ url('myaccount/trade/sell')}}" class="form-horizontal" >
{{ csrf_field() }}
<div class="form-group">
        <label>{{ trans('forms.balance')}} : </label>
        <span id="sellerbalance"></span> <span class="tocurrency"></span>
        <span id="buy_token"></span>
      
    </div>
       <div class="row {{ $errors->has('buy_volume') ? ' has-error' : '' }}">

     <div class="col-md-3">
         <label >Amount
            <!-- {{ trans('forms.volume_lbl') }} -->
             (<span class="tocurrency"></span>)</label>
     </div>
      <div class="col-md-9"> 

        <input name="sell_volume" class="form-control" value="{{ old('sell_volume') }}" id="sell_volume" type="text" onkeyup="getSellExchangeValue();">
    <small class="text-danger">{{ $errors->first('sell_volume') }}</small>
    </div>
        
    </div>  <br/>

    <div class="row {{ $errors->has('sell_amount') ? ' has-error' : '' }}">
     <div class="col-md-3">
         <label><!-- {{ trans('forms.trade_buy_amount_lbl') }} --> Price (1 <span class="tocurrency"></span>)</label>
         </div>
         <div class="col-md-9"> 
        <input name="sell_amount" class="form-control form-inline" value="{{  old('sell_amount') }}" id="sell_amount" type="text" onkeyup="getSellExchangeValue();"> (<span class="fromcurrency"></span>)
        <small class="text-danger">{{ $errors->first('sell_amount') }}</small>
        </div>
    </div> 

     <div class="grid grid-two">

        <label>Amount: <span id="sfinaltot_amount">0</span></label>
        <label>{{ trans('forms.fee_lbl') }} : <span id="sbuy_fee_amount">0</span></label>
        <label>{{ trans('forms.pay_amount_lbl') }} : <span id="sbuy_exchange_amount">0</span> <span class="fromcurrency"></span> </label>
         
    </div>

   <!--  <div class="grid grid-two{{ $errors->has('sell_volume') ? ' has-error' : '' }}">
        <label>{{ trans('forms.sell_volume_lbl') }}</label>

      
        <input name="sell_volume" class="form-control" value="{{ old('sell_volume') }}" id="sell_volume" type="text" onkeyup="getSellExchangeValue();">
        <small class="text-danger">{{ $errors->first('sell_volume') }}</small>
    </div>    

    <div class="grid grid-two{{ $errors->has('sell_amount') ? ' has-error' : '' }}">

  
   <label>{{ trans('forms.trade_sell_amount_lbl') }}</label>

        <input name="sell_amount" class="form-control" value="{{  old('sell_amount') }}" id="sell_amount" type="text" onkeyup="getSellExchangeValue();">
        <small class="text-danger">{{ $errors->first('sell_amount') }}</small>
    </div> 
      <div class="grid grid-two{{ $errors->has('sell_payment_thro') ? ' has-error' : '' }}">
        <label for="payment_thro">{{ trans('forms.payment_thro_lbl') }}</label>
     
        <select class="form-control" id="sell_payment_thro" name="sell_payment_thro" onchange="getSellExchangeValue();">
            <option value="">Select</option>              
        
        </select>
                <small class="text-danger">{{ $errors->first('sell_payment_thro') }}</small>
    </div> 
      <div class="grid grid-two">
        <label>{{ trans('forms.fee_lbl') }}</label>
        <input type="text" name="fee_amount" id="sell_fee_amount" class='form-control' value="{{ old('fee_amount') }}" readonly>
       <small class="text-danger"></small>
    </div>

    <div class="grid grid-two">
        <label>{{ trans('forms.total_amount_lbl') }} </label>
        <input type="text" name="exchange_amount" id="sell_exchange_amount" class='form-control' value="{{ old('exchange_amount') }}" readonly>
        <small class="text-danger"></small>
      
    </div>       -->
    <br/> 

    <div class="form-group">
         <input type="hidden" name="sfromcur" id="sfromcur" value="">
       <input type="hidden" name="stocur" id="stocur" value="">
       <input type="hidden" name="sfromcurid" id="sfromcurid" value="">
       <input type="hidden" name="stocurid" id="stocurid" value="">
       <input type="hidden" name="scurrency_pair" id="scurrency_pair" value="">

        <input value="{{ trans('forms.sell_btn') }}" class="btn btn-primary" type="submit" id="myBtn"> 
        
    </div>

</form>
@push('bottomscripts')
<script type="text/javascript">
// $.ajaxSetup({
// headers: {
//     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
// }
// });


function getSsellExchangeValue(val)
{


    $('#sell_exchange_amount').val('');
    
    var sell_amount = $('#sell_amount').val();

    var sell_volume = $('#sell_volume').val();

    var sell_payment_thro = $('#sell_payment_thro').val();
    if(sell_amount>0)
    {
        $.post("{{url("myaccount/trade/getsellexchange")}}", { amount: sell_amount,volume:sell_volume,payment_thro:sell_payment_thro})
          .done(function( data ) {
            $('#sell_exchange_amount').val(data.final_amount);
            $('#sell_fee_amount').val(data.fee_total);
       });
    }
}

function getSellExchangeValue(val)
{
    //alert("KK");
    $('#buy_exchange_amount').val('');
    var buy_amount = $('#sell_amount').val();
    var buy_volume = $('#sell_volume').val();

    var buy_payment_thro = $('#sfromcur').val();
  
    var currency_pair = $('#scurrency_pair').val();
    var fromcurid = $('#sfromcurid').val();
    var fromcur = $('#sfromcur').val();
    var tocur = $('#stocur').val();


    if(buy_amount>0)
    {
        //alert("JJ");
            // var total=buy_volume*buy_amount;
            // $('#buy_fee_amount').html("10");
            // $('#buy_exchange_amount').html(total);

           // $('#buy_token').html(data.token);
    
        $.post("{{url("myaccount/trade/getsellexchange")}}", { amount: buy_amount,payment_thro:buy_payment_thro,volume:buy_volume,currency_pair:currency_pair,fromcurid:fromcurid,fromcur:fromcur,tocur:tocur})
          .done(function( data ) {

            
            $('#sbuy_exchange_amount').html(data.final_amount);
            $('#sbuy_fee_amount').html(data.fee_total);
            $('#sfinaltot_amount').html(data.finaltot_amount);

           // $('#buy_balance').html(data.balance);
            //$('#buy_token').html(data.token);
       });


    }
}
</script>
@endpush

