<?php

namespace App\Traits;
use Event;
use App\Events\CreateERC20TokenWallet;
use App\Models\Currency;
use App\Traits\Common;
use App\Exchangerate;
use App\Traits\ERC20TokenBuyProcess;
use App\Models\Userprofile;
use App\Models\Usercurrencyaccount;
use Carbon\Carbon;
use App\Models\TradeCurrencyPair;
trait ERC20TokenProcess
{
    use Common,ERC20TokenBuyProcess,TransactionProcess;

 
    public function createERC20Token($currency_data)
    {
                $create=[  
                        'name'=>$currency_data->token_symbol,
                        'token'=>$currency_data->token_symbol,
                        'displayname'=>$currency_data->token_name,
                        'image'=>$currency_data->token_image,
                        'token_status'=>$currency_data->active,
                        'type'=>'token',                                              
                      ];


               $currency= Currency::create($create);
                      
               $createpair=[  
                'from_currency_id'=>$currency->id,
                'to_currency_id'=>3,
                'base_fee'=>100,
                'fee'=>0.5,
                'status'=>'active',
                'min_value'=>1,
                'max_value'=>100                                              
              ];
         
               $currencya= TradeCurrencyPair::create($createpair);
              Event::fire(new CreateERC20TokenWallet($currency));
          
            return true;
    }
    public function updateERC20Token($currency_data)
    {
          $update=[ 

                        'token_status'=>$currency_data->active,
                                                                                                 
                      ];

                Currency::where('name',$currency_data->token_symbol)->update($update);
        

            return true;
    }
       public function createERC20TokenWallets($currency)
    {
        
       $users = Userprofile::whereIn('usergroup_id', ['1', '3'])->get();
        foreach ($users as $data)
        {
            
            if ($data->usergroup_id == '1')
            {
                $account_no = "A-".$currency->name."-".(10000 + $data->id );

                $usercurrencyaccount = new Usercurrencyaccount;
                $usercurrencyaccount->account_no = $account_no;
                $usercurrencyaccount->user_id = $data->user_id;
                $usercurrencyaccount->currency_id = $currency->id;
                $usercurrencyaccount->created_at = Carbon::now();
                $usercurrencyaccount->updated_at = Carbon::now(); 
                $usercurrencyaccount->save();

            }
            else
            {
                $account_no = "U-".$currency->name."-".(10000 + $data->id );

                $usercurrencyaccount = new Usercurrencyaccount;
                $usercurrencyaccount->account_no = $account_no;
                $usercurrencyaccount->user_id = $data->user_id;
                $usercurrencyaccount->currency_id = $currency->id;
                $usercurrencyaccount->created_at = Carbon::now();
                $usercurrencyaccount->updated_at = Carbon::now(); 
                $usercurrencyaccount->save();
            }
        }

       
      
            return true;
    }

    

  
	public  function getTokenRate($amount, $from_currency_name, $to_currency_name,$type,$token_value)
  {

        //Payment Gateway -$to_currency_name

        $exchangerates=Exchangerate::latest()->first();

        $exchange_rates=json_decode($exchangerates['exchange_rates'],true);
    
        \session::put('token_exchange_rates',$exchange_rates);
        $total='0';
        if(count($exchange_rates)>0)
        {
             foreach ($exchange_rates['rates'] as $key => $value)
              {
                    if ($key == $to_currency_name)
                    {
                        $tocurrencyvalue = $value;
                    }
                     
              }


              if ($to_currency_name != $from_currency_name)
              {
                  
                   if ($type=='buy')
                    {

                        $per_token=1/$token_value;//Per Token Value
                        $total=$amount*$per_token*$tocurrencyvalue;

                    }

                   
              }
        }
        $total=sprintf('%0.8f',$total);

          return $total;
    }
     public function tokenSessionToRequest()
    {

        $array=[
            "token_amount"=>\Session::get('token_amount'),
            "total_amount"=>\Session::get('token_total_amount'),
            "transaction_id"=>\Session::get('transaction_id'),
            "request_token_id"=>\Session::get('token_currency_id'),
            "from_currency"=>\Session::get('token_from_currency_id'),
            "from_address"=>\Session::get('token_from_address'),
            "to_address"=>\Session::get('token_pay_address'),
            "token_equivalent"=>\Session::get('token_buy_equi'),
            "exchangerate"=>\Session::get('token_exchange_rates'),
          
            ];

                      \Session::forget('token_amount'); 
                      \Session::forget('token_total_amount'); 
                      \Session::forget('transaction_id');
                     \Session::forget('token_from_currency_id'); 
                     
                 
                  
           
      
      return $array;
    }
 }

