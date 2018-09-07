@component('mail::message')

{{ trans('mail.hi_text', ['name' => 'Admin']) }},<br>

{{ trans('mail.contactus_content', ['name' => $fromname]) }}<br>
{{ rawurldecode($queries) }}<br>

{!! $signature !!}
{{ $contactno }}<br>
{{ $skypeid }}<br>
@endcomponent
