@component('mail::message')

{{ trans('mail.hi_text', ['name' => $name]) }},<br>

<p>{{ trans('mail.email_verification_content') }}
    @component('mail::button', ['url' => url('emailverification', $link)])
    {{ trans('mail.email_verification_button_text') }}
    @endcomponent
</p>

{!! $signature !!}

@endcomponent
