@component('mail::message')

{{ trans('mail.hi_text', ['name' => $name]) }},<br>

{{ trans('mail.withdraw_rejected_content', array(
    'amount' => $amount, 'currency' => $currency)) }}<br>

{{ $comments }} <br>

{!! $signature !!}
@endcomponent
