<div class="col-md-12 ">

    <form method="post" action="{{url('admin/sendmail')}}" class="form-horizontal" >
    {{ csrf_field() }}


        <div class="form-group">
            <label>{{ trans('mail.to') }} </label>
            <label>{{$user->name}} < {{$user->email}} ></label>      
        </div> 

        <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
            <label>{{ trans('mail.subject') }}</label>
            <input type="text" name="subject" value="{{ old('subject') }}" class="form-control"  placeholder="Enter the subject">
            <small class="text-danger">{{ $errors->first('subject') }}</small>
        </div> 
     
        <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
           <label>{{ trans('mail.msg') }}</label>
            <textarea  rows="5" class="form-control"  placeholder="Message " name="message" id="message" >{{ old('message') }}</textarea>
            <small class="text-danger">{{ $errors->first('message') }}</small>
        </div>  
        
        <div class="form-group">
            <input value="Send" class="btn btn-primary" type="submit" onclick="this.disabled=true;this.form.submit();"> 
          
             <a href="{{ url('admin/users/'.$user_id) }}" class='btn btn-info'>{{ trans('mail.back') }}</a>
        </div>
    </form> 
    <hr>
</div>

@push('scripts')
    <script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
    <script>
    $(document).ready(function() 
    {
      CKEDITOR.replace( 'message' );
     
    });
    </script>
@endpush