@extends('layouts.app') 

@section('content')

<div class="flex container mt-40 mb-40">
         
        <div class="col col-md-9">
         <h1 class="page-title">{{ trans('forms.buy_coin_title',['coin'=>$currencydetails->displayname]) }}</h1>
           <div class="row">

           <div class="col-md-10 col-md-offset-1">

            <p> {!! trans('forms.buy_coin_instruction',['txnid'=>$transaction_id]) !!}</p>

            
            <form method="POST" action="{{ url('myaccount/buycoin/confirm') }}">  
                 {{ csrf_field() }}

                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <td>{{ trans('forms.order_amount_lbl') }} </td>
                              <td> <label for="input01">{{ $amount }} </label></td>
                              <input name="amount" class="form-control" value="{{ $amount }}" type="hidden">
                            </tr> 
                            <tr>
                              <td> {{ trans('forms.transaction_ref_id') }} </td> 
                              <td><label for="input01">{{ $transaction_id }}</label>
                          <input name="transaction_id" class="form-control" value="{{ $transaction_id }}" type="hidden"></td>
                            </tr> 
                           <tr>
                              
                            <tr>
                              <td>{{ trans('forms.account_no_lbl') }}</td> 
                              <td><label for="input01">{{ $currencyaccounts->account_no }}</label>
                        
                            </tr> 
                           
                          </tbody>
                        </table>




                         

                        <div class="form-group">
                          <input value="{{ trans('forms.submit_complete_btn') }}" class="btn btn-success" type="submit" onclick="this.disabled=true;this.form.submit();"> 
                                  
                                <a href="{{ url('myaccount/home') }}" class="btn btn-primary">{{ trans('forms.back') }}</a>
                        </div>

                </form>
              </div>
        </div>
      </div>
    </div>

@endsection


            