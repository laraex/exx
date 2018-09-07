<div class="p-20">
<form method="post" action="/contact" class="form-horizontal" id="contact">
{{ csrf_field() }}
    <div class="form-group{{ $errors->has('fullname') ? ' has-error' : '' }}">
        <input name="fullname" class="form-control" value="{{ (Form::old('fullname') != '' ? old('fullname') : $fullname) }}" type="text" placeholder="{{ trans('forms.your_name') }}">
        <small class="text-danger">{{ $errors->first('fullname') }}</small>
    </div> 

    <div class="form-group{{ $errors->has('emailid') ? ' has-error' : '' }}">
        <input name="emailid" class="form-control" value="{{ (Form::old('emailid') != '' ? old('emailid') : $email) }}" type="text" placeholder="{{ trans('forms.your_email') }}">
        <small class="text-danger">{{ $errors->first('emailid') }}</small>
    </div>    

     <div class="form-group{{ $errors->has('contactno') ? ' has-error' : '' }}">
        <input name="contactno" class="form-control" value="{{ (Form::old('contactno') != '' ? old('contactno') : $contactno) }}" type="text" placeholder="{{ trans('forms.your_contact_no') }}">
        <small class="text-danger">{{ $errors->first('contactno') }}</small>
    </div> 

   <div class="form-group">
        <input name="socialaddress" class="form-control" value="{{ old('socialaddress') }}" type="text" placeholder="{{ trans('forms.your_skype_gtalk') }}">        
    </div> 

    <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
        <textarea  rows="5" class="form-control"  placeholder="{{ trans('forms.your_query') }}" name="message">{{ old('message') }}</textarea>
        <small class="text-danger">{{ $errors->first('message') }}</small>
    </div>  

 @if(!Auth::user() && (Config::get('settings.contactus_captcha_status') == '1'))        
    <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
        <div class="g-recaptcha" data-sitekey="{{ Config::get('settings.captchasitekey') }}"></div>
        <small class="text-danger">{{ $errors->first('g-recaptcha-response') }}</small>
    </div>  
@endif  
    
    <div class="form-group">
        {!! Form::submit(trans('forms.submit_btn'), ['class' => 'btn btn-primary']) !!}
        <a href="{{ url('contact') }}" class='btn btn-default'>{{ trans('forms.reset') }}</a>
    </div>
</form>
</div>

@push('bottomscripts')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endpush
