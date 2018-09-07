<form method="post" action="{{ url('myaccount/viewpayaccounts/type')}}/{{$coinname}}" class="form-horizontal" onsubmit="return checkltcaddress()">
{{ csrf_field() }}
    <div class="form-group{{ $errors->has('ltc_address') ? ' has-error' : '' }}">
        <label>{{ trans('forms.ltc_address_lbl') }}</label>
        <input name="ltc_address" class="form-control" value="{{ (Form::old('ltc_address') != '' ? old('ltc_address') : $user->userprofile->ltc_address) }}" id="ltc_address" type="text">
        <small class="text-danger">{{ $errors->first('ltc_address') }}</small>
    </div>    

           

    <div class="form-group">
        {!! Form::submit(trans('forms.submit_btn'), ['class' => 'btn btn-primary']) !!}
        <a href="" class='btn btn-default'>{{ trans('forms.reset') }}</a>
    </div>

</form>

@push('bottomscripts')
<script src={{'/js/wallet-address-validator.min.js'}} type="text/javascript"></script>
<script>
//1KFzzGtDdnq5hrwxXGjwVnKzRbvf8WVxck

 function checkltcaddress(){

      var type= '{{ env('BTC_MODE') }}';
      

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

          }
        


    }


</script>

@endpush