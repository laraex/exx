@component('mail::message')

{{ trans('mail.hi_text', ['name' => 'Admin']) }},<br>

<p>{{$content }}</p>

<p>{{ trans('mail.added_amount') }} : {{ $deposited_amount }} {{ $currency }}</p>


{!! $signature !!}  
@endcomponent
