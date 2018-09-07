<!DOCTYPE html>
<html lang="en">
<head>
  <style type="text/css">
.table-bordered {
    border: 1px solid #ddd;
}
.table {
    margin-bottom: 20px;
    max-width: 100%;
    width: 100%;
}
table {
    background-color: transparent;
}
table {
    border-collapse: collapse;
    border-spacing: 0;
}

.table-bordered > tbody > tr > td {
    border: 1px solid #ddd;
}
.table > tbody > tr > td {
    border-top: 1px solid #ddd;
    line-height: 1.42857;
    padding: 8px;
    vertical-align: top;
}

  </style>
</head>
<body>
<center><h4>{{ trans('forms.bankwireinvoice') }}</h4></center>
         
  <table class="table table-bordered">
   
    <tbody>
      <tr>
        <td>{{ trans('forms.amount_to_be_deposited') }}</td>
        <td>{{ Session::get('amount') }} {{ \Config::get('settings.currency') }}</td>
      </tr>     

      <tr>
        <td>{{ trans('forms.transaction_ref_id') }}</td>
        <td>{{ Session::get('transactionnumber') }}</td>
      </tr>

       <tr>
        <td>{{ trans('forms.bank_name_lbl') }}</td>
        <td>{{ $params['bank_name'] }}</td>
      </tr>

       <tr>
        <td>{{ trans('forms.address') }}</td>
        <td>{{ $params['bank_address'] }}</td>
      </tr>

      <tr>
        <td>{{ trans('forms.swift_code_lbl') }}</td>
        <td>{{ $params['swift_code'] }}</td>
      </tr>

      <tr>
        <td>{{ trans('forms.account_name_lbl') }}</td>
        <td>{{ $params['account_name'] }}</td>
      </tr>

      <tr>
        <td>{{ trans('forms.account_no_lbl') }}</td>
        <td>{{ $params['account_no'] }}</td>
      </tr>

      
    </tbody>
  </table>


</body>
</html>
