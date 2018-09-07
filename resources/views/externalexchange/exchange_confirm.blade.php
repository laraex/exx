
@extends('layouts.app')

@section('content')

<div class="flex container mt-40 mb-40">
       
        <div class="col col-md-9">
            <h1 class="page-title">{{ trans('forms.exchange_pair_title',['from'=>$pair_details->fromcurrency->name,'to'=>$pair_details->tocurrency->name]) }}</h1>
                        <div class="panel-body">                  

                            <div class="row">
                             
                               @include('partials.message')
                                       <div class="col-md-12">
                                <form method="POST" action="{{ url('myaccount/externalexchange/confirm') }}">  
                 {{ csrf_field() }}

                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <td>{{ trans('forms.exchange_amount_lbl') }} </td>
                              <td> <label for="input01">{{\Session::get('external_exchange_amount') }} {{ $pair_details->fromcurrency->name}}</label></td>
                              
                            </tr> 

                            <tr>
                              <td>{{ trans('forms.exchange_to_amount_lbl') }} </td>
                              <td> <label for="input01">{{\Session::get('external_exchange_final_amount') }} {{ $pair_details->tocurrency->name}}</label></td>
                              
                            </tr>

                             <tr>
                              <td>{{ trans('forms.exchange_fee_lbl') }} </td>
                              <td> <label for="input01">{{\Session::get('external_exchange_fee_total') }} {{ $pair_details->tocurrency->name}}</label></td>
                              
                            </tr> 
                            <tr>
                              <td> {{ trans('forms.transaction_ref_id') }} </td> 
                              <td><label for="input01">{{ $transaction_id }}</label></td>
                         
                            </tr> 
                            
                            
                            
                            
                           
                          </tbody>
                        </table>

                        <div class="form-group">
                          <input value="{{ trans('forms.submit_complete_btn') }}" class="btn btn-success" type="submit" onclick="this.disabled=true;this.form.submit();"> 
                               
                          <a href="{{ url('myaccount/externalexchange/create') }}" class="btn btn-primary">{{ trans('forms.back') }}</a>
                        </div>

                </form>
                </div>

                            </div>                 
                 
                         </div>
       </div>
</div>
@endsection




