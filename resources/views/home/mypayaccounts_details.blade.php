@foreach($allpayaccounts as $key=>$value)
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="rcorners1">
          <h4>{{ trans('forms.bank_balance',['bankbalance'=>$value->currency->displayname]) }}</h4>
          {{--{{ $value->present()->getBalance($value->currency->id, $value->userpayaccounts[0]->user_id) }}--}}
        </div>
          @foreach($value->userpayaccounts as $account)
            <a href="{{ url('/myaccount/viewbankdetails/'.$account->id) }}" class="">
              <div class="rcorners2 col-md-4">
                <div>{{ $account->param1 }}</div>
                <div>{{ $account->param3 }}</div>
                <div>
                  @if($account->current == '1')
                    <a class="bankauto" href="{{ url('myaccount/currentaccounts/'.$account->id.'/'.$account->paymentgateways_id.'/'.$account->current)}}">{{ trans('forms.yes') }}</a>
                  @else
                    <a class="bankauto" href="{{ url('myaccount/currentaccounts/'.$account->id.'/'.$account->paymentgateways_id.'/'.$account->current)}}">{{ trans('forms.no') }}</a>
                  @endif
                </div>  
              </div>
            </a> 
          @endforeach
        <a href="{{ url('/myaccount/payaccounts/'.$value->id) }}" class="">
          <div class="col-md-4 addaccount">
           {{ trans('forms.bank_ac') }} 
          </div>    
        </a> 
      </div>     
    </div>
  </div>
@endforeach
        
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
  .rcorners1 
  {
    border-radius: 25px;
    border: 2px solid #73AD21;
    padding: 20px; 
    width: 200px;
    height: 150px;  
    margin:5px;
  }

  .rcorners2 
  {
    border-radius: 25px;
    border: 2px solid #73AD21;
    padding: 20px; 
    width: 150px;
    height: 100px;  
    margin:5px;
  }
  
  .addaccount 
  {
    background-color: #ccc;
  }

  .addaccount::before 
  {
    content: "+";
    height:150px;
    width:200px;
    font-size:200px;
    display:flex;
    flex-direction:row;
    align-items:center;
    justify-content:center;
    font-weight:bold;
    font-family:courier;
    color:white;
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