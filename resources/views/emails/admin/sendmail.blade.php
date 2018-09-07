@component('mail::message')

{{ trans('mail.hi_text', ['name' => $username]) }},<br>

{!! $message !!}

{!! $signature !!}

@endcomponent
