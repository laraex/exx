@php

  if ($data->userpayaccounts->paymentgateways_id == 1)
  {
    $datacontent = trans('forms.bank_name_lbl'). ':' .$data->userpayaccounts->param1.'<br/>';  
    $datacontent .= trans('forms.swift_code_lbl'). ':' .$data->userpayaccounts->param2.'<br/>';  
    $datacontent .= trans('forms.account_no_lbl'). ':' .$data->userpayaccounts->param3.'<br/>';  
    $datacontent .= trans('forms.account_name_lbl'). ':' .$data->userpayaccounts->param4.'<br/>';  
    $datacontent .= trans('forms.account_address_lbl'). ':' .$data->userpayaccounts->param5.'<br/>'; 
@endphp
    <span data-html="true" data-toggle="popover"  data-content="{{ $datacontent }}">{{ $data->userpayaccounts->payment->displayname }}</span> 

@php
    }
    elseif ($data->userpayaccounts->paymentgateways_id == 2)
    {
      $datacontent = trans('forms.paypal_id_lbl'). ' : ' .$data->userpayaccounts->param1;
@endphp
      <span data-html="true" data-toggle="popover"  data-content="{{ $datacontent }}">{{ $data->userpayaccounts->payment->displayname }}</span> 
@php              
    }
    elseif ($data->userpayaccounts->paymentgateways_id == 3)
    {
      $datacontent = trans('forms.user_name_lbl'). ':' .$data->userpayaccounts->param1;
@endphp
      <span data-html="true" data-toggle="popover"  data-content="{{ $datacontent }}">{{ $data->userpayaccounts->payment->displayname }}</span>
@php            
    }
    elseif ($data->userpayaccounts->paymentgateways_id == 4)
    {
          $datacontent = trans('forms.payeer_id_lbl'). ':' .$data->userpayaccounts->param1;
          $datacontent .= trans('forms.payeer_email_lbl'). ':' .$data->userpayaccounts->param2; 
@endphp
      <span data-html="true" data-toggle="popover"  data-content="{{ $datacontent }}">{{ $data->userpayaccounts->payment->displayname }}</span> 
@php               
      }
      elseif ($data->userpayaccounts->paymentgateways_id == 5)
      {
        $datacontent = trans('forms.account_emailid_lbl'). ':' .$data->userpayaccounts->param1;
@endphp
       <span data-html="true" data-toggle="popover"  data-content="{{ $datacontent }}">{{ $data->userpayaccounts->payment->displayname }}</span> 
@php                              
      }
      elseif ($data->userpayaccounts->paymentgateways_id == 9)
      {
        $datacontent = trans('forms.bitcoin_coinname_lbl'). ':' .$data->userpayaccounts->param1;  
        $datacontent .= trans('forms.bitcoin_btccode_lbl'). ':' .$data->userpayaccounts->param2;
@endphp
       <span data-html="true" data-toggle="popover"  data-content="{{ $datacontent }}">{{ $data->userpayaccounts->payment->displayname }}</span>
@php                               
      }
    elseif ($data->userpayaccounts->paymentgateways_id == 11)
      {
        $datacontent = trans('forms.skrill_email_lbl'). ':' .$data->userpayaccounts->param1;
@endphp
       <span data-html="true" data-toggle="popover"  data-content="{{ $datacontent }}">{{ $data->userpayaccounts->payment->displayname }}</span>
@php                               
    }
    elseif ($data->userpayaccounts->paymentgateways_id == 12)
    {
          $datacontent = trans('forms.okpay_payid_lbl'). ':' .$data->userpayaccounts->param1; 
          $datacontent .= trans('forms.okpay_paynumber_lbl'). ':' .$data->userpayaccounts->param2;
@endphp
     <span data-html="true" data-toggle="popover"  data-content="{{ $datacontent }}">{{ $data->userpayaccounts->payment->displayname }}</span>
@php                                
      }
      elseif ($data->userpayaccounts->paymentgateways_id == 15)
    {
          $datacontent = trans('forms.payee_account_lbl'). ':' .$data->userpayaccounts->param1;         
@endphp
     <span data-html="true" data-toggle="popover"  data-content="{{ $datacontent }}">{{ $data->userpayaccounts->payment->displayname }}</span>
@php                                
      } 
      elseif ($data->userpayaccounts->paymentgateways_id == 16)
    {
          $datacontent = trans('forms.merchant_id_lbl'). ':' .$data->userpayaccounts->param1."</br>"; 
          $datacontent .= trans('forms.merchant_key_lbl'). ':' .$data->userpayaccounts->param2;                 
@endphp
     <span data-html="true" data-toggle="popover"  data-content="{{ $datacontent }}">{{ $data->userpayaccounts->payment->displayname }}</span>
@php                                
      }                       
@endphp 