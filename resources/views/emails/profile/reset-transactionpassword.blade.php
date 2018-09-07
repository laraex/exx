@component('mail::message')

{{ trans('mail.hi_text', ['name' => $name]) }},<br>

<p>{{ $reset_transaction_password_content }}</p>

<p>{{ $new_transaction_password_content }} {{ $new_transaction_password }}</p>

<p>
    @component('mail::button', ['url' => $reset_transaction_password_link])
    {{ $transaction_password_link_text }}
    @endcomponent
</p>

{!! $signature !!}
@endcomponent
