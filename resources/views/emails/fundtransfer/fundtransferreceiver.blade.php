@component('mail::message')

{{ trans('mail.hi_text', ['name' => $receiver]) }},<br>

<p>
{{ trans('mail.fund_transfer_receive_content', array(
    'amount' => $amount, 'currency' => $currency, 'sender' => $sender)) }}

    @component('mail::button', ['url' => $actionUrl])
    {{ trans('mail.click_to_login') }}
    @endcomponent
</p>

{!! $signature !!}

@endcomponent
