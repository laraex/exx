<form method="post" action="{{ url('myaccount/type/doge/send')}}" class="form-horizontal" onsubmit="return checkdogeaddress()">
{{ csrf_field() }}
    <div class="form-group{{ $errors->has('doge_address') ? ' has-error' : '' }}">
        <label>{{ trans('forms.doge_address_lbl') }}</label>
        <input name="doge_address" class="form-control" value="{{ old('doge_address') }}" id="doge_address" type="text">
        <small class="text-danger">{{ $errors->first('doge_address') }}</small>
    </div>    

    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
        <label>{{ trans('forms.send_amount_lbl') }} (DOGE)</label>
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

 function checkdogeaddress(){


      var type= '{{ env('DOGE_MODE') }}';
      

      var mode=1;
      if(type=='live')
      {  
         mode=0;
      }
        
           var doge_address = $('#doge_address').val();

           if(doge_address!='')
           {
             if(mode==0)
             {
                 // type="live";
                   var valid = WAValidator.validate(doge_address, 'DOGE');
             }
             else
             {
                 // type="testnet";

                  var valid = WAValidator.validate(doge_address, 'DOGE','testnet');
             }

 
             if(!valid)
             {

               alert("Enter Valid DOGE Address");
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
            alert("Enter  DOGE Address");
             return false;
          }
        


    }


</script>

@endpush