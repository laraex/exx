@component('mail::message')

Hi {{ $username }},

<p>{{$message }}
    @component('mail::button', ['url' => $resetlink])
    {{ $resetlinktext }}
    @endcomponent
</p>
{!! $signature !!}

@endcomponent



