<form method="post" action="{{ url('myaccount/type/btc/send')}}" class="form-horizontal" onsubmit="return checkbtcaddress()">
{{ csrf_field() }}
    <div class="form-group{{ $errors->has('btc_address') ? ' has-error' : '' }}">
        <label>{{ trans('forms.btc_address_lbl') }}</label>
        <input name="btc_address" class="form-control" value="{{ old('btc_address') }}" id="btc_address" type="text">
        <small class="text-danger">{{ $errors->first('btc_address') }}</small>
    </div>    

    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
        <label>{{ trans('forms.send_amount_lbl') }} (BTC)</label>
        <input name="amount" class="form-control" value="{{  old('amount') }}" id="amount" type="text">
        <small class="text-danger">{{ $errors->first('amount') }}</small>
    </div>      

    <div class="form-group">
   

        <input value="{{ trans('forms.submit_btn') }}" class="btn btn-primary" type="submit" id="myBtn"> 
        <a href="" class='btn btn-default'>{{ trans('forms.reset') }}</a>
    </div>

</form>

@push('bottomscripts')
<script src={{'/js/wallet-address-validator.min.js'}} type="text/javascript"></script>
<script>
//1KFzzGtDdnq5hrwxXGjwVnKzRbvf8WVxck

 function checkbtcaddress(){


      var type= '{{ env('BTC_MODE') }}';
      

      var mode=1;
      if(type=='live')
      {  
         mode=0;
      }
        
           var btc_address = $('#btc_address').val();

           if(btc_address!='')
           {
             if(mode==0)
             {
                 // type="live";
                   var valid = WAValidator.validate(btc_address, 'BTC');
             }
             else
             {
                 // type="testnet";

                  var valid = WAValidator.validate(btc_address, 'BTC','testnet');
             }

 
             if(!valid)
             {

               alert("Enter Valid BTC Address");
               return false;
             }
             else
             {

                document.getElementById("myBtn").disabled = true;
                return true;
             }

          }
          else
          {
            alert("Enter  BTC Address");
             return false;
          }
        


    }


</script>

@endpush