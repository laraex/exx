@component('mail::message')

{{ trans('mail.hi_text', ['name' => $name]) }},<br>

<p>{{ trans('mail.user_ticket_content', array(
    'staff' => $staff, 'category' => $category, 'priority' => $priority, 'status' => $status )) }} </p>

<p>{{ trans('mail.subject') }} : {{ $subject }} </p>
<p>{{ trans('mail.description') }} : {{ $content }} </p>

{!! $signature !!}
@endcomponent
