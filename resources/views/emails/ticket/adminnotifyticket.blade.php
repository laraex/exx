@component('mail::message')

{{ trans('mail.hi_text', ['name' => $name]) }},<br>

<p>{{ trans('mail.admin_ticket_content', array(
    'user' => $user, 'staff' => $staff, 'category' => $category, 'priority' => $priority, 'status' => $status )) }} </p>

<p>{{ trans('mail.subject') }} : {{ $subject }} </p>
<p>{{ trans('mail.description') }} : {{ $content }} </p>
<p>
    @component('mail::button', ['url' => $actionUrl])
    {{ $actionText }}
    @endcomponent
</p>

{!! $signature !!}

@endcomponent
