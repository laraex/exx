@component('mail::message')

{{ trans('mail.hi_text', ['name' => $name]) }},<br>

<P>
{{ trans('mail.new_deposit_content', array(
    'amount' => $amount, 'currency' => $currency)) }}
</P> 


<p>{{ trans('mail.transaction_number') }} : {{ $transaction_number }} </p>

{!! $signature !!}
@endcomponent
