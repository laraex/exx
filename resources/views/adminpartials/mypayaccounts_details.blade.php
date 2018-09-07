@foreach($allpayaccounts as $key=>$value)
  <h4>{{ trans('forms.bank_title',['bankname'=>$value->displayname]) }}</h4>
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
              </tr>
            </thead>

            <tbody>
              @foreach($value->userpayaccount as $account)
                <tr>
                  <td>{{ $account->param1 }}</td>
                  <td>{{ $account->param2 }}</td>
                  <td>{{ $account->param3 }}</td>
                  <td>{{ $account->param4 }}</td>
                  <td>{{ $account->param5 }}</td>
                </tr>
              @endforeach    
            </tbody>
          </table>
      </div>
    </div>
  </div>
  <hr>
@endforeach

