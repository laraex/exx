@component('mail::message')

{{ trans('mail.hi_text', ['name' => 'Admin']) }},<br>

<p>{{ trans('mail.kyc_upload_content', ['name' => $name, 'proof' => $proof]) }} </p>

{!! $signature !!}
@endcomponent
