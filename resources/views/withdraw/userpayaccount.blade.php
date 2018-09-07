<div class="col-md-10 col-md-offset-1">

<div class="form-group">
        <label>{{ trans('forms.admin_commission') }} :</label>
        {{ $admincommission }} %      
    </div> 

@foreach($payaccount_result as $payaccount)
@php
$current = '';
if ($payaccount['current'] == 1)
{
    $current = 'checked';
}
@endphp


@if ($payaccount['paymentgateways_id'] == 1)
    
    <div class="form-group">
        <input type="radio" name="userpayaccountid" value="{{ $payaccount['id'] }}" {{ $current }}>&nbsp;<label>{{ trans('forms.bitcoin_coinname_lbl') }} :</label>
        {{ $payaccount['param1'] }}       
    </div>     

    <div class="form-group">
        <label>{{ trans('forms.bitcoin_btccode_lbl') }} :</label>
        {{ $payaccount['param2'] }}      
    </div>     
    
@endif

@if ($payaccount['paymentgateways_id'] > 1)    

    <div class="form-group">
        <input type="radio" name="userpayaccountid" value="{{ $payaccount['id'] }}" {{ $current }}>&nbsp;<label>{{ trans('forms.bank_name_lbl') }} :</label>
        {{ $payaccount['param1'] }}       
    </div> 

    <div class="form-group">
        <label>{{ trans('forms.swift_code_lbl') }} :</label>
        {{ $payaccount['param2'] }}       
    </div> 

    <div class="form-group">
        <label>{{ trans('forms.account_no_lbl') }} :</label>
        {{ $payaccount['param3'] }}       
    </div> 

    <div class="form-group">
        <label>{{ trans('forms.account_name_lbl') }} :</label>
        {{ $payaccount['param4'] }}       
    </div> 

    <div class="form-group">
        <label>{{ trans('forms.account_address_lbl') }} :</label>
        {{ $payaccount['param5'] }}       
    </div> 
    
@endif

@endforeach

</div>





