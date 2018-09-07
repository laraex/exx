<div class="col-md-12 ">
<form method="post" action="{{ url('admin/withdraw/reject/'.$withdrawid)}}" class="form-horizontal" id="contact">
{{ csrf_field() }}

    <div class="form-group">
      {{ trans('admin_withdraw.username') }} : {{ $withdrawdetail->user->name }}
    </div> 
    <div class="form-group">
      {{ trans('admin_withdraw.amount') }} : {{ $withdrawdetail->amount }} {{ config::get('settings.currency') }}
    </div>     
    @include('admin.withdraw.userpayaccount')
    <input type="hidden" name="transactionid" value="{{ $withdrawdetail->transaction_id }}">
    <input type="hidden" name="userid" value="{{ $withdrawdetail->user_id }}">
    <input type="hidden" name="amount" value="{{ $withdrawdetail->amount }}">
 
    <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
        <textarea  rows="5" class="form-control"  placeholder="Comments" name="comment">{{ old('comment') }}</textarea>
        <small class="text-danger">{{ $errors->first('comment') }}</small>
    </div>  


    
    <div class="form-group">
        {!! Form::submit(trans('forms.submit_btn'), ['class' => 'btn btn-primary']) !!}
        <a href=" " class='btn btn-default'>{{ trans('forms.reset') }}</a>
    </div>
</form>
</div>
