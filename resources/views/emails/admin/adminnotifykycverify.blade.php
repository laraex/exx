@component('mail::message')

{{ trans('mail.hi_text', ['name' => $admin]) }},<br>

<p>{{$message }}</p>

<p>
    @component('mail::button', ['url' => $actionUrl])
    {{ $actionText }}
    @endcomponent
</p>
{!! $signature !!}

@endcomponent
