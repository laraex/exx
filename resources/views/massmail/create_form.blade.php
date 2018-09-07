<div class="col-md-6 ">
    <form method="post" class="form-horizontal" >
        {{ csrf_field() }}
            <div class="form-group{{ $errors->has('to') ? 'has-error' : '' }}">
                <label>{{ trans('mail.to') }}</label>
                    <select class="form-control" id="to" name="to">
                        <option value="">Select</option>
                            @foreach($users as $key=>$to)
                                <option value="{{ $key }}" {{ (Form::old("to") == $key ? "selected":"") }}>{{ $to }}</option>
                            @endforeach
                    </select>
                <small class="text-danger"> {{ $errors->first('to') }}</small> 
            </div>
    
            <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                <label>{{ trans('mail.subject') }}</label>
                <input type="text" name="subject" value="{{ old('subject') }}" class="form-control"  placeholder="Enter the  subject">
                <small class="text-danger">{{ $errors->first('subject') }}</small>
            </div> 

            <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                <label>{{ trans('mail.msg') }}</label>
                <textarea  rows="5" class="form-control"  placeholder="Message " name="message" id="message" >{{ old('message') }}</textarea>
                <small class="text-danger">{{ $errors->first('message') }}</small>
            </div>  
    
            <div class="form-group">
                <input value="Send" class="btn btn-primary" type="submit" onclick="this.disabled=true;this.form.submit();"> 
                <input type="submit" class="btn btn-primary" value="Reset"> </a>
            </div>
    </form>
</div>

<hr>
@push('scripts')
<script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
<script>
$(document).ready(function() 
{
  CKEDITOR.replace( 'message' );
 
});
</script>
@endpush