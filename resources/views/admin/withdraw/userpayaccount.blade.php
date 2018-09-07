@if ($userpayaccounts->paymentgateways_id == 1)
    
    <div class="form-group">
       <label>{{ trans('forms.bitcoin_coinname_lbl') }} :</label>
        {{ $userpayaccounts->param1 }}       
    </div>     

    <div class="form-group">
        <label>{{ trans('forms.bitcoin_btccode_lbl') }} :</label>
        {{ $userpayaccounts->param2 }}      
    </div>     
    
@endif


@if ($userpayaccounts->paymentgateways_id > 1)

    <div class="form-group">
        <label>{{ trans('forms.bank_name_lbl') }} :</label>
        {{ $userpayaccounts->param1 }}       
    </div> 

    <div class="form-group">
        <label>{{ trans('forms.swift_code_lbl') }} :</label>
        {{ $userpayaccounts->param2 }}       
    </div> 

    <div class="form-group">
        <label>{{ trans('forms.account_no_lbl') }} :</label>
        {{ $userpayaccounts->param3 }}       
    </div> 

    <div class="form-group">
        <label>{{ trans('forms.account_name_lbl') }} :</label>
        {{ $userpayaccounts->param4 }}       
    </div> 

    <div class="form-group">
        <label>{{ trans('forms.account_address_lbl') }} :</label>
        {{ $userpayaccounts->param5 }}       
    </div> 
    
@endif













