@component('mail::message')

{{ trans('mail.hi_text', ['name' => $name]) }},<br>

{{ trans('mail.kyc_rejected_content') }}<br>

{!! $signature !!}
@endcomponent