<form method="post" action="{{ url('myaccount/trade/buy')}}" class="form-horizontal" >
{{ csrf_field() }}
<div class="form-group">
        <label>{{ trans('forms.balance')}} : <span id="userbalance"></span> 
            <span class="fromcurrency"></span> </label>
        <span id="buy_balance"></span>
        <span id="buy_token"></span>
    </div>
    <div class="row {{ $errors->has('buy_volume') ? ' has-error' : '' }}">

     <div class="col-md-3">
         <label >Amount
            <!-- {{ trans('forms.volume_lbl') }} -->
             (<span class="tocurrency"></span>)</label>
     </div>
      <div class="col-md-9"> 

        <input name="buy_volume" class="form-control" value="{{ old('buy_volume') }}" id="buy_volume" type="text" onkeyup="getBuyExchangeValue();">
        <small class="text-danger">{{ $errors->first('buy_volume') }}</small>
    </div>
        
    </div>  <br/>  

    <div class="row {{ $errors->has('buy_amount') ? ' has-error' : '' }}">
     <div class="col-md-3">
         <label>Price (1 <span class="tocurrency"></span>)</label>
         </div>
         <div class="col-md-9"> 
        <input name="buy_amount" class="form-control form-inline" value="{{  old('buy_amount') }}" id="buy_amount" type="text" onkeyup="getBuyExchangeValue();"> (<span class="fromcurrency"></span>)
        <small class="text-danger">{{ $errors->first('buy_amount') }}</small>
        </div>
    </div> 

    

    <div class="grid grid-two">
 
        <label>Amount: <span id="finaltot_amount">0</span></label>
        <label>{{ trans('forms.fee_lbl') }} : <span id="buy_fee_amount">0</span></label>
        <label>{{ trans('forms.pay_amount_lbl') }} : <span id="buy_exchange_amount">0</span> <span class="fromcurrency"></span> </label>
         
    </div>

     
<br/> 

    <div class="form-group">
   
       <input type="hidden" name="fromcur" id="fromcur" value="">
       <input type="hidden" name="tocur" id="tocur" value="">
       <input type="hidden" name="fromcurid" id="fromcurid" value="">
       <input type="hidden" name="tocurid" id="tocurid" value="">
    <input type="hidden" name="currency_pair" id="currency_pair" value="">
        
        <input value="{{ trans('forms.buy_btn') }}" class="btn btn-primary" type="submit" id="myBtn"> 
       
    </div>

</form>

@push('bottomscripts')

@if(old('buy_amount')!='')

<script type="text/javascript">
    $(document).ready(function() {
       
         var buy_amount = $('#buy_amount').val();
    var buy_volume = $('#buy_volume').val();
    
    var buy_payment_thro ='{{old('fromcur')}}'; 
  
    var currency_pair ='{{old('currency_pair')}}';
    var fromcurid ='{{old('fromcurid')}}';
     var tocurid ='{{old('tocurid')}}';
    var fromcur = '{{old('fromcur')}}';
    var tocur = '{{old('tocur')}}';


    if(buy_amount>0)
    {
      
    
        $.post("{{url("myaccount/trade/getbuyexchange")}}", { amount: buy_amount,payment_thro:buy_payment_thro,volume:buy_volume,currency_pair:currency_pair,fromcurid:fromcurid,fromcur:fromcur,tocur:tocur})
          .done(function( data ) {

         
            $('#buy_exchange_amount').html(data.final_amount);
            $('#buy_fee_amount').html(data.fee_total);
            $('#finaltot_amount').html(data.finaltot_amount);

          
       });

   }
     });
</script>
@endif
<script type="text/javascript">
$.ajaxSetup({
headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});



function getBuyExchangeValue(val)
{
    //alert("KK");
    $('#buy_exchange_amount').val('');
    var buy_amount = $('#buy_amount').val();
    var buy_volume = $('#buy_volume').val();

    var buy_payment_thro = $('#fromcur').val();
  
    var currency_pair = $('#currency_pair').val();
    var fromcurid = $('#fromcurid').val();
     var tocurid = $('#tocurid').val();
    var fromcur = $('#fromcur').val();
    var tocur = $('#tocur').val();


    if(buy_amount>0)
    {

    
        $.post("{{url("myaccount/trade/getbuyexchange")}}", { amount: buy_amount,payment_thro:buy_payment_thro,volume:buy_volume,currency_pair:currency_pair,fromcurid:fromcurid,fromcur:fromcur,tocur:tocur})
          .done(function( data ) {

            
            $('#buy_exchange_amount').html(data.final_amount);
            $('#buy_fee_amount').html(data.fee_total);
            $('#finaltot_amount').html(data.finaltot_amount);

           // $('#buy_balance').html(data.balance);
            //$('#buy_token').html(data.token);
       });

     // $.get("{{url("myaccount/getbuyexchange")}}", { amount: buy_amount,payment_thro:buy_payment_thro,volume:buy_volume,currency_pair:currency_pair,fromcurid:fromcurid,tocurid:tocurid})
     //      .done(function(data) {
     //               alert("JJ");
     //                  alert(data.fee_total);
     //        });
}
}


</script>
@endpush

