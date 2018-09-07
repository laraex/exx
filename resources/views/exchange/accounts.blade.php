@extends('layouts.app')

@section('content')
    <div class="member-content">
            <div class="inner-wrapper accounts mt-40 mb-40">
            @include('partials.message')
                    <div class="container">
                        <input type="hidden" id="activecurrency" value="{{$scurrency[0]->id}}">
                            <div  class="grid grid-380-580-380 gc-20">
                            <div class="flex-col-1">
                                 <currency-pair></currency-pair>
                            </div>
                            <div class="flex-col-2">
                                 <currency-wallet></currency-wallet>
                                 <br/>

                                <!--  <transaction-history></transaction-history> -->

                            </div>
                            <div class="flex-col-3">
                              <my-assets></my-assets> 
                            </div>
                          </div>
     
                </div>
            </div>
    </div>


    <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">{{ trans('forms.add_bank_title') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          

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
                    <input type="hidden" name="paymentid" id="paymentid" value="">
                   <input value="{{ trans('forms.submit_btn') }}" class="btn btn-success" id="payment" type="submit"> 

                   <input value="{{ trans('forms.reset') }}" class="btn btn-primary"  type="reset"> 

                   <a href="{{ url('myaccount/viewpayaccounts') }}" class="btn btn-info">{{ trans('forms.back') }}</a>       
              </div>           
            </form>
           
        </div>
    </div>
</div>


@endsection
@push('bottomscripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
<script type="text/javascript">
function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
    $('#copy').val("Copied");
    $('#copy').addClass("copytext");
}
$(document).ready(function () {

    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
    $("#success-alert").slideUp(500);
    });


    $('[data-paymentid]').click(function(){

         alert("JJ");  
    });
       alert("dd");
    $('#modalLoginForm').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('paymentid');
       
        $('#paymentid').val(rowid);
             
     });

 $("#bankwire_usd_form").validate({
        errorClass: 'help-block',
        validClass: 'valid',
        highlight: function(element) {
            $(element).closest('div').addClass("has-error");
        },
        unhighlight: function(element) {
            $(element).closest('div').removeClass("has-error");
        },
        errorPlacement: function(error, element) {
          $(element).closest('div').append(error);
        },
        rules: {             
              bank_name: {
                required: true                
            },
            swift_code: {
                required: true,
                validswiftcode: true,              
            },
            account_no: {
                required: true                
            },
            account_name: {
                required: true                
            },
            account_address: {
                required: true                
            }                   
        },
        messages: {          
            bank_name: {
                required: "Bank Name is required"              
            },
            swift_code: {
                required: "Swift Code is required",
                validswiftcode : "Enter valid swift code."             
            },
            account_no: {
                required: "Account Number is required"              
            },
            account_name: {
                required: "Account Name is required"              
            },
            account_address: {
                required: "Account Address is required"              
            }
        }
    });

 });

</script>