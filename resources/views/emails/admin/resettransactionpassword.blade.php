@component('mail::message')

{{ trans('mail.hi_text', ['name' => $name]) }},<br>

{{ trans('mail.token',['token' => $token]) }},<br>

<p>
    @component('mail::button', ['url' => $resetlink])
    {{ $resetlinktext }}
    @endcomponent
</p>

{!! $signature !!}
@endcomponent



