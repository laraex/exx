 <div class="wallet-info">
<div class="flex flex-c">
    <div class="flex account-info">
            <div><img src="{{  url($currencydetails->image)  }}" class="dashlet-flag"></div>
            <div>
                <p>
                    <strong>{{ $currencydetails->displayname }} Wallet </strong><br/>
                   <small>{{ $currencyaccounts->account_no }}</small> 
                </p>
            </div>
     </div>     
     <div class="balance-info">
            <p>
                <strong>
                {{ $currencydetails->displayname }}  {{ $currencyaccounts->present()->getBalance($currencydetails->id,$currencyaccounts->user_id) }}
                </strong>
            </p>
            
    </div>  
 </div>
 
</div>