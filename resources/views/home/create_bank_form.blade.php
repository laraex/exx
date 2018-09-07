<div class="mb-20 mt-20">
    <div class="grid grid-490-490"> 
        <div class="d-card w-490">
            <div class="d-card-plan">
                <div class="plan-list-item">
                    <div class="flex flex-c">
                        <div class="plan-info-1">
	                    	<div class="grid grid-150-auto">
		                        <div>{{ trans('forms.bank_name_lbl') }}</div>
		                        <div>{{ $account->param1 }}</div>

								<div>{{ trans('forms.swift_code_lbl') }}</div>
								<div>{{ $account->param2 }}</div>

								<div>{{ trans('forms.account_no_lbl') }}</div>
								<div>{{ $account->param3 }}</div>

								<div>{{ trans('forms.account_name_lbl') }}</div>
								<div>{{ $account->param4 }}</div>

								<div>{{ trans('forms.account_address_lbl') }}</div>
								<div>{{ $account->param5 }}</div>

								<div>{{ trans('forms.autowithdraw') }}</div>
								<div>
		                            @if($account->current == '1')
		                              <a class="bankauto" href="{{ url('myaccount/currentaccounts/'.$account->id.'/'.$account->paymentgateways_id.'/'.$account->current)}}">{{ trans('forms.yes') }}</a>
		                            @else
		                              <a class="bankauto" href="{{ url('myaccount/currentaccounts/'.$account->id.'/'.$account->paymentgateways_id.'/'.$account->current)}}">{{ trans('forms.no') }}</a>
		                            @endif
		                        </div>

		                        <div>{{ trans('forms.actions') }}</div>
		                        <div>
		                            <form method="post" class="bankremovefrm" action="{{ url('myaccount/removeaccount/'.$account->id.'') }}">
		                              {{ csrf_field()}}
		                            	<div class="form-group">
		                                	<button type="submit" value="Remove" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button>
		                                </div>
		                            </form>
		                        </div>
	                      	</div>
                    	</div>
                  	</div>
                </div>
            </div>
        </div>
    </div>
</div>
           
@section('customstyles')
  <style>
    @media only screen and (min-width : 320px) 
    {
      .w-490
      {
        max-width:auto;
      }
      .grid-490-490
      {

        grid-template-columns:auto;
        grid-gap:20px;
      } 
      
      .grid-150-auto
      {
        grid-template-columns:150px auto;
        grid-gap:10px;
      }  
      }
      @media only screen and (min-width : 992px) 
      {
        .w-490
      {
        max-width:490px;
      }

      .grid-490-490
      {
        grid-template-columns:490px 490px;
        grid-gap:20px;
      }   
      }
  </style>
@endsection

@push('bottomscripts')
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style> 
#rcorners1 {
   border-radius: 25px;
    border: 2px solid #73AD21;
    padding: 20px; 
    width: 200px;
    height: 150px;  
}

#rcorners2 {
    border-radius: 25px;
    border: 2px solid #73AD21;
    padding: 20px; 
    width: 200px;
    height: 150px;    
}

#rcorners3 {
    border-radius: 25px;
    border: 2px solid #73AD21;
    padding: 20px; 
    width: 200px;
    height: 150px;    
}

#rcorners4 {
    border-radius: 25px;
    border: 2px solid #73AD21;
    padding: 20px; 
    width: 200px;
    height: 150px;    
}

</style>

  <script>
      $(".bankremovefrm").on("submit", function(){
          return confirm("{{ trans('forms.pay_account_remove_alert') }}");
      });
       $(".bankauto").on("click", function(){
          return confirm("{{ trans('forms.auto_withdraw_alert') }}");
      });
  </script>
@endpush