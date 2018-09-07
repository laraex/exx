<div class="col-md-12 ">
<form method="post" action="{{ url('admin/message/conversation/save/'.$conversationid)}}" class="form-horizontal" id="contact">
{{ csrf_field() }} 

    <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
        <textarea  rows="5" class="form-control"  placeholder="Enter your message here" name="message" required="required">{{ old('message') }}</textarea>
        <small class="text-danger">{{ $errors->first('message') }}</small>
    </div>
    
    <div class="form-group">
        {!! Form::submit(trans('forms.submit_btn'), ['class' => 'btn btn-primary']) !!}
        <a href="" class='btn btn-default'>{{ trans('forms.reset') }}</a>
    </div>
</form>
</div>