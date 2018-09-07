@component('mail::message')

{{ trans('mail.hi_text', ['name' => 'Admin']) }},<br>

{{ trans('mail.withdraw_request_content', ['name' => $name]) }}<br>

{{ trans('mail.withdraw_request_amount_text', ['amount' => $amount]) }} {{ $currency }}<br>

{!! trans('mail.user_signature', array('name' => $name)) !!}
@endcomponent
