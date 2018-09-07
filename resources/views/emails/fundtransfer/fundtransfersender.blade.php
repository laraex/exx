@component('mail::message')

{{ trans('mail.hi_text', ['name' => $sender]) }},<br>

<p>
{{ trans('mail.fund_transfer_sender_content', array(
    'amount' => $amount, 'currency' => $currency, 'receiver' => $receiver)) }}
</p>
{!! $signature !!}

@endcomponent
