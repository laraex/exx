<form method="post" action="{{ url('myaccount/viewpayaccounts/type')}}/{{$coinname}}" class="form-horizontal" onsubmit="return checkethaddress()">
{{ csrf_field() }}
    <div class="form-group{{ $errors->has('eth_address') ? ' has-error' : '' }}">
        <label>{{ trans('forms.eth_address_lbl') }}</label>
        <input name="eth_address" class="form-control" value="{{ (Form::old('eth_address') != '' ? old('eth_address') : $user->userprofile->eth_address) }}" id="eth_address" type="text">
        <small class="text-danger">{{ $errors->first('eth_address') }}</small>
    </div>    

           

    <div class="form-group">
        {!! Form::submit(trans('forms.submit_btn'), ['class' => 'btn btn-primary']) !!}
        <a href="" class='btn btn-default'>{{ trans('forms.reset') }}</a>
    </div>

</form>

@push('bottomscripts')
<script src={{'/js/ethereum-address.js'}} type="text/javascript"></script>
<script>
//1KFzzGtDdnq5hrwxXGjwVnKzRbvf8WVxck

 function checkethaddress(){

      
     // var ethereum_address = require('ethereum-address');
              
           var eth_address = $('#eth_address').val();
      
            if (isAddress_check(eth_address)) {
               // console.log('Valid ethereum address.');
             

                  return true;
                }
                else {
                // console.log('Invalid Ethereum address.');

                  alert("Enter Valid ETH Address");
                  return false;
                }

        
        


    }




 

</script>

@endpush