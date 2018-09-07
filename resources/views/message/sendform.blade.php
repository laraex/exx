<div class="bgd-box-round p-20">
<form method="post" action="{{ url('myaccount/message/save')}}" class="form-horizontal" id="contact">
{{ csrf_field() }} 

    <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
        <textarea  rows="5" class="form-control"  placeholder="{{trans('forms.entermsg')}}" name="message" >{{ old('message') }}</textarea>
        <small class="text-danger">{{ $errors->first('message') }}</small>
    </div>  


    
    <div class="form-group">
        {!! Form::submit(trans('forms.submit_btn'), ['class' => 'btn btn-primary']) !!}
        <a href="" class='btn btn-default'>{{ trans('forms.reset') }}</a>
    </div>
</form>
</div>
