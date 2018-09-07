<h4>{{ trans('forms.my_bank_wire_usd') }}</h4>
@if(count($bankwire_usd_result) > 0)
   @include('home._mypayaccounts_bankwire_usd_details')
@endif
<p>
<a href="" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#bank_usd">{{ trans('forms.add_bank_account') }}</a>                       
</p>
<hr>
 <!-- Modal -->
  <div class="modal fade" id="bank_usd" role="dialog"> 
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{ trans('forms.usd_bank_details_form') }}</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
             <form method="post" id="bankwire_usd_form" action="{{ url('myaccount/payaccounts')}}">
            {{ csrf_field() }}
              <div class="form-group">
                <label class="control-label">{{ trans('forms.bank_name_lbl') }}:</label>
                <input type="text" class="form-control" id="bank_name" name="bank_name">
              </div> 
              <div class="form-group">
                <label class="control-label">{{ trans('forms.swift_code_lbl') }}:</label>
                <input type="text" class="form-control" id="swift_code" name="swift_code">
              </div> 
              <div class="form-group">
                <label class="control-label">{{ trans('forms.account_no_lbl') }}:</label>
                <input type="text" class="form-control" id="account_no" name="account_no">
              </div> 
              <div class="form-group">
                <label class="control-label">{{ trans('forms.account_name_lbl') }}:</label>
                <input type="text" class="form-control" id="account_name" name="account_name">
              </div> 
              <div class="form-group">
                <label class="control-label">{{ trans('forms.account_address_lbl') }}:</label>
                <input type="text" class="form-control" id="account_address" name="account_address">
              </div> 
              <div class="form-group">
                    <input type="hidden" name="paymentid" value="2">
                   <input value="{{ trans('forms.submit_btn') }}" class="btn btn-success" id="payment" type="submit">        
              </div>           
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>