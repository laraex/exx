@extends('layouts.app') 

@section('content')

<div class="flex container mt-40 mb-40">
          <div class="col col-md-3">
                  @include('fund.partials._sidebar_fund')
          </div>
        <div class="col col-md-9">
         <h1 class="page-title">{{ trans('forms.add_fund') }}</h1>
           <div class="row">

           <div class="col-md-10 col-md-offset-1">

            <p> {{ $instructions }}</p>

            
            <form method="POST" action="{{ url('myaccount/addfund/bankwire') }}">  
                 {{ csrf_field() }}
        
 <input name="paymentgateway" class="form-control" value="{{ $paymentgateway }}" type="hidden">

                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <td>{{ trans('forms.amount_to_be_deposited') }} </td>
                              <td> <label for="input01">{{ $amount }} {{ $currencyname }}</label></td>
                              <input name="amount" class="form-control" value="{{ $amount }}" type="hidden">
                            </tr> 
                            <tr>
                              <td> {{ trans('forms.transaction_id') }} </td> 
                              <td><label for="input01">{{ $transaction_id }}</label>
                          <input name="transaction_id" class="form-control" value="{{ $transaction_id }}" type="hidden"></td>
                            </tr> 
                            <tr>
                              <td> {{ trans('forms.bank_name_lbl') }} </td> 
                              <td> <label for="input01">{{ $params['bank_name'] }}</label>
                          <input name="bank_name" class="form-control" value="{{ $params['bank_name'] }}" type="hidden"></td>
                            </tr> 
                            <tr>
                              <td>{{ trans('forms.address') }}</td>
                               <td> <label for="input01">{{ $params['bank_address'] }}</label>
                          <input name="bank_address" class="form-control" value="{{ $params['bank_address'] }}" type="hidden"></td>
                            </tr> 
                            <tr>
                              <td>{{ trans('forms.swift_code_lbl') }}</td> 
                              <td><label for="input01">{{ $params['swift_code'] }}</label>
                          <input name="swift_code" class="form-control" value="{{ $params['swift_code'] }}" type="hidden"></td>
                            </tr> 
                            <tr>
                              <td>{{ trans('forms.account_name_lbl') }}</td> 
                              <td> <label for="input01">{{ $params['account_name'] }}</label>
                          <input name="account_name" class="form-control" value="{{ $params['account_name'] }}" type="hidden"></td>
                            </tr> 
                            <tr>
                              <td>{{ trans('forms.account_no_lbl') }}</td> 
                              <td><label for="input01">{{ $params['account_no'] }}</label>
                          <input name="account_no" class="form-control" value="{{ $params['account_no'] }}" type="hidden"></td>
                            </tr> 
                            <tr>
                              <td>                             
                               <input value="{{ trans('forms.submit_complete_btn') }}" class="btn btn-success" type="submit" onclick="this.disabled=true;this.form.submit();"> 

                                <a href="{{ url('myaccount/bankwire/printinvoice') }}" class="btn btn-info" target="_blank">{{ trans('forms.printinvoice') }}</a>  
                               <a href="{{ url('myaccount/accounts') }}" class="btn btn-primary">{{ trans('forms.backtomywallet') }}</a>
                               
                               </td> 
                              <td></td>
                            </tr>
                          </tbody>
                        </table>
                </form>
              </div>
        </div>
      </div>
    </div>

@endsection


            