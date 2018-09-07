<div class="col-md-12 ">

<form method="post" action="{{ url('admin/cryptowithdraw/approve/'.$transfer->id)}}" class="form-horizontal" id="contact">
{{ csrf_field() }}
   <div class="form-group">
        <label>{{ trans('admin_fund.transaction_no') }} </label>
        <label>{{ $transfer->transaction_id }}</label>
    </div>   
    <div class="form-group">
        <label> Amount </label>
       <label>{{ sprintf("%0.8f",$transfer->amount) }}  {{ $transfer->currency->token }}</label>
    </div>  
    <div class="form-group">
        <label> Fee </label>
       <label>{{ sprintf("%0.8f",$transfer->fee_total) }}  {{ $transfer->currency->token }}</label>
    </div> 
   <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
        <textarea  rows="5" class="form-control"  placeholder="Comments, usually the transaction reference from your account like... " name="comment" id="comment" ></textarea>
        <small class="text-danger">{{ $errors->first('comment') }}</small>
    </div>  
  <div class="form-group">
        {!! Form::submit(trans('forms.confirm_btn'), ['class' => 'btn btn-primary']) !!}

         <a href="{{ url('admin/cryptowithdraw/pending/') }}" class='btn btn-info'>{{ trans('admin_fund.back_list') }}</a>
    </div>
    </form> 
    <hr>
    

        

</div>

