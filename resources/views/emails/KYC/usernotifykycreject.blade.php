@component('mail::message')

{{ trans('mail.hi_text', ['name' => $name]) }},<br>

<p>{{ trans('mail.kyc_reject_content') }} </p>

<p>hello</p>

{!! $signature !!}
@endcomponent


