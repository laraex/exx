@component('mail::message')

{{ trans('mail.hi_text', ['name' => 'Admin']) }},<br>

<p>{{$message }}</p>
<p>{{ trans('mail.username') }} : {{ $registered_user_name }}</p>
<p>{{ trans('mail.registerd_ip_address') }} : {{ $ip_address }}</p>
<p>
    @component('mail::button', ['url' => $actionUrl])
    {{ $actionText }}
    @endcomponent
</p>
{!! $signature !!}

@endcomponent
