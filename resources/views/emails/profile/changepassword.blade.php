@component('mail::message')

{{ trans('mail.hi_text', ['name' => $name]) }},<br>

{{ $message }}<br>

{!! $signature !!}
@endcomponent
