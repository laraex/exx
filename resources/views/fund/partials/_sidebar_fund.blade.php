 <div class="wallet-info">
<div class="flex flex-c">
    <div class="flex account-info">
            <div><img src="{{  url($currencydetails->image)  }}" class="dashlet-flag"></div>
            <div>
                <p>
                    <strong>{{ $currencydetails->displayname }} Wallet </strong><br/>

              @if($currencydetails->name=='PrimaryCoin')
                <p>
                @php
                $acc_no=str_replace('PrimaryCoin',$currencydetails->token,$account_no);

                @endphp
                   
                   <small>{{ $acc_no }}</small> 
                </p>
                @else

                  <small>{{ $account_no }}</small>
                @endif 
                  
                </p>
            </div>
     </div>     
     <div class="balance-info">
            <p>
                <strong>
                {{ $currencydetails->displayname }}  {{ $currency_accounting_code->present()->getBalance($currency_accounting_code->currency->id, $user_id) }}
                </strong>
            </p>
           {{-- <hr>
            <ul>

            @if($currencydetails->name=='PrimaryCoin')

             <a href="{{ url('myaccount/buy/setcoin/'.$currencydetails->id) }}">Add Funds</a><br/>
               
             <a href="{{ url('myaccount/fundtransfer/redirectform/'.$currencydetails->id) }}">Fund Transfer</a>

            @else
                <a href="{{ url('myaccount/addfundcurrency/'.$currencydetails->id) }}">Add Funds</a><br/>
                <a href="{{ url('myaccount/withdraw/redirectform/'.$currencydetails->id) }}">Withdraw</a><br/>
                <a href="{{ url('myaccount/fundtransfer/redirectform/'.$currencydetails->id) }}">Fund Transfer</a>

            @endif
            </ul>--}}
    </div>  
 </div>
 
</div>