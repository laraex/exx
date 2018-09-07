<div class="row">
    <div class="col-md-12">    
    <div class="table-responsive">          
        <table class="table table-bordered table-hover">
          <thead>
            <tr>        
              <th>{{ trans('forms.bank_name_lbl') }}</th>
              <th>{{ trans('forms.swift_code_lbl') }}</th>
              <th>{{ trans('forms.account_no_lbl') }}</th>
              <th>{{ trans('forms.account_name_lbl') }}</th>
              <th>{{ trans('forms.account_address_lbl') }}</th>
              <th>{{ trans('forms.autowithdraw') }}</th>
              <th>{{ trans('forms.actions') }}</th>       
            </tr>
          </thead>
          <tbody>
          @foreach($bankwire_result as $bankwire)
            <tr>
              <td>{{ $bankwire->param1 }}</td>
              <td>{{ $bankwire->param2 }}</td>
              <td>{{ $bankwire->param3 }}</td>
              <td>{{ $bankwire->param4 }}</td>
              <td>{{ $bankwire->param5 }}</td>
              <td>
               @if($bankwire->current == '1')
                <a class="bankauto" href="{{ url('myaccount/currentaccounts/'.$bankwire->id.'/'.$bankwire->paymentgateways_id.'/'.$bankwire->current)}}">{{ trans('forms.yes') }}</a>
              @else
                <a class="bankauto" href="{{ url('myaccount/currentaccounts/'.$bankwire->id.'/'.$bankwire->paymentgateways_id.'/'.$bankwire->current)}}">{{ trans('forms.no') }}</a>
              @endif
              </td> 
              <td>
              <form method="post" class="bankremovefrm" action="{{ url('myaccount/removeaccount/'.$bankwire->id.'') }}">
                {{ csrf_field()}}
                <div class="form-group">
                          <button type="submit" value="Remove" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button>
                </div>
              </form>
              </td>           
            </tr>
            @endforeach    
          </tbody>
        </table>
    </div>
    </div>
  </div>
    @push('bottomscripts')
<script>
    $(".bankremovefrm").on("submit", function(){
        return confirm("{{ trans('forms.pay_account_remove_alert') }}");
    });
     $(".bankauto").on("click", function(){
        return confirm("{{ trans('forms.auto_withdraw_alert') }}");
    });
</script>
@endpush