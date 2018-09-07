@component('mail::message')

{{ trans('mail.hi_text', ['name' => $name]) }},<br>
<p>{{ trans('mail.otp') }} : {{ $otp }}</p>

<p> 
@component('mail::button', ['url' => $otplink])
   {{ trans('mail.otplink_text')}}
@endcomponent
</p>

{!! $signature !!}
   
@endcomponent