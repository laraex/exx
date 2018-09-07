@component('mail::message')

{{ trans('mail.hi_text', ['name' => $name]) }},<br>

<p>{{ trans('mail.kyc_verify_content') }} </p>

{!! $signature !!}
@endcomponent
