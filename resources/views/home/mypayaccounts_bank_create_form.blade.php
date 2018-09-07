


<h4>{{ trans('forms.add_bank_title',['bankname'=>$payment->displayname]) }}</h4>

             <form method="post" id="bankwire_usd_form" action="{{ url('myaccount/payaccounts')}}">
            {{ csrf_field() }}
              <div class="form-group{{ $errors->has('bank_name') ? ' has-error' : '' }}">
                <label class="control-label">{{ trans('forms.bank_name_lbl') }}:</label>
                <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ old('bank_name')}}">
                <small class="text-danger">{{ $errors->first('bank_name') }}</small>
              </div> 
              <div class="form-group{{ $errors->has('swift_code') ? ' has-error' : '' }}">
                <label class="control-label">{{ trans('forms.swift_code_lbl') }}:</label>
                <input type="text" class="form-control" id="swift_code" name="swift_code" value="{{ old('swift_code')}}">
                <small class="text-danger">{{ $errors->first('swift_code') }}</small>
              </div> 
              <div class="form-group{{ $errors->has('account_no') ? ' has-error' : '' }}">
                <label class="control-label">{{ trans('forms.account_no_lbl') }}:</label>
                <input type="text" class="form-control" id="account_no" name="account_no" value="{{ old('account_no')}}">
                <small class="text-danger">{{ $errors->first('account_no') }}</small>
              </div> 
              <div class="form-group{{ $errors->has('account_name') ? ' has-error' : '' }}">
                <label class="control-label">{{ trans('forms.account_name_lbl') }}:</label>
                <input type="text" class="form-control" id="account_name" name="account_name" value="{{ old('account_name')}}">
                <small class="text-danger">{{ $errors->first('account_name') }}</small>
              </div> 
              <div class="form-group{{ $errors->has('account_address') ? ' has-error' : '' }}">
                <label class="control-label">{{ trans('forms.account_address_lbl') }}:</label>
                <input type="text" class="form-control" id="account_address" name="account_address" value="{{ old('account_address')}}">
                <small class="text-danger">{{ $errors->first('account_address') }}</small>
              </div> 
              <div class="form-group">
                    <input type="hidden" name="paymentid" value="{{$payment->id}}">
                   <input value="{{ trans('forms.submit_btn') }}" class="btn btn-success" id="payment" type="submit"> 
                   <input value="{{ trans('forms.reset') }}" class="btn btn-primary"  type="reset"> 

                   <a href="{{ url('myaccount/viewpayaccounts') }}" class="btn btn-info">{{ trans('forms.back') }}</a>       
              </div>           
            </form>

     
 