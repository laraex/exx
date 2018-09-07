<form method="post" action="{{ url('myaccount/type/ltc/send')}}" class="form-horizontal">
{{ csrf_field() }}
    <div class="form-group{{ $errors->has('ltc_address') ? ' has-error' : '' }}">
        <label>{{ trans('forms.ltc_address_lbl') }}</label>
        <input name="ltc_address" class="form-control" value="{{ old('ltc_address') }}" id="ltc_address" type="text">
        <small class="text-danger">{{ $errors->first('ltc_address') }}</small>
    </div>    

    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
        <label>{{ trans('forms.send_amount_lbl') }} (LTC)</label>
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

 function checkltcaddress(){


      var type= '{{ env('LTC_MODE') }}';
      

      var mode=1;
      if(type=='live')
      {  
         mode=0;
      }
        
           var ltc_address = $('#ltc_address').val();

           if(ltc_address!='')
           {
             if(mode==0)
             {
                 // type="live";
                   var valid = WAValidator.validate(ltc_address, 'LTC');
             }
             else
             {
                 // type="testnet";

                  var valid = WAValidator.validate(ltc_address, 'LTC','testnet');
             }

 
             if(!valid)
             {

               alert("Enter Valid LTC Address");
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
            alert("Enter  LTC Address");
             return false;
          }
        


    }


</script>

@endpush