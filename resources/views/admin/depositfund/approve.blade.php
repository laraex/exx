<div class="col-md-12 ">

<form method="post" action="{{ url('admin/depositfund/approve/'.$transactionid)}}" class="form-horizontal" id="contact">
{{ csrf_field() }}
   <div class="form-group">
        <label>{{ trans('admin_fund.transaction_no') }} </label>
        <label>{{ $transaction->transaction_id }}</label>
    </div>   
    <div class="form-group">
        <label>{{ trans('admin_fund.invoice_amt') }} </label>
       <label>{{ $transaction->amount }}  {{ $transaction->currency->token }}</label>
    </div>  
    <div class="form-group{{ $errors->has('depositamount') ? ' has-error' : '' }}">
        <label>{{ trans('admin_fund.amt_receive') }}</label>
        <input type="number" name="depositamount" id="depositamount" class="form-control" required="required" value="{{old('depositamount')}}">
        <small class="text-danger">{{ $errors->first('depositamount') }}</small>
    </div>  
   <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
        <textarea  rows="5" class="form-control"  placeholder="Comments, usually the transaction reference from your account like... " name="comment" id="comment" ></textarea>
        <small class="text-danger">{{ $errors->first('comment') }}</small>
    </div>  
  <div class="form-group">
        {!! Form::submit(trans('forms.confirm_btn'), ['class' => 'btn btn-primary']) !!}

         <a href="{{ url('admin/actions/fund/') }}" class='btn btn-info'>{{ trans('admin_fund.back_list') }}</a>
    </div>
    </form> 
    <hr>
    

        

</div>

@push('scripts')

<script type="text/javascript">

$(document).ready(function() {
       
    //  $("#addedfund").on("click", function(){
    //     return confirm("Do you want to added this deposit amount to user account balance? ");

    // });

     $(".addbalance").on("submit", function(){       

        if (confirm('{{ trans("admin_fund.add_deposit") }}')) 
        {
            var depositamount = $('#depositamount').val();
            $('#receivedamount').val(depositamount);
            var comment = $('#comment').val();
            $('#problemcomment').val(comment);
                if (depositamount == '' || comment == '')
                {
                    alert('{{ trans("admin_fund.mandatory") }}');
                    return false;
                }
               
                return true;
        } 
        else 
        {
            
            return false;
        }
    });      
});

</script>
@endpush
