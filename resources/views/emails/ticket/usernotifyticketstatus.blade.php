@component('mail::message')

{{ trans('mail.hi_text', ['name' => $name]) }},<br>

<p>{{ trans('mail.user_ticket_status_content', array(
    'status' => $status )) }} </p>

<p>{{ trans('mail.subject') }} : {{ $subject }} </p>
<p>{{ trans('mail.description') }} : {{ $content }} </p>
<p>{{ trans('mail.category') }} : {{ $category }} </p>
<p>{{ trans('mail.priority') }} : {{ $priority }} </p>
<p>
    @component('mail::button', ['url' => $actionUrl])
    {{ $actionText }}
    @endcomponent
</p>

{!! $signature !!}

@endcomponent
