@component('mail::message')

{{ trans('mail.hi_text', ['name' => $name]) }},<br>

{{ trans('mail.kyc_approved_content') }}.<br>

{!! $signature !!}
@endcomponent