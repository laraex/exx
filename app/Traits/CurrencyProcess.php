<?php
/**
 * Trait for processing common
 */
namespace App\Traits;


use App\Models\Currency;
use App\Models\Userprofile;
use App\Models\Usercurrencyaccount;
use App\Models\Paymentgateway;
use Carbon\Carbon;
/**
 *
 * @class trait
 * Trait for Common Processes
 */
trait CurrencyProcess
{
    /**
     * Getting a Value from Settings
     *
     * @param [type] $key
     * @return string
     */
    public function createCurrencyWallets($currency_data)
    {
        
       $users = Userprofile::whereIn('usergroup_id', ['1', '3'])->get();
        foreach ($users as $data)
        {
            $currency = Currency::where('id', $currency_data->id)->first();

            if ($data->usergroup_id == '1')
            {
                $account_no = "A-".$currency->name."-".(10000 + $data->id );

                $usercurrencyaccount = new Usercurrencyaccount;
                $usercurrencyaccount->account_no = $account_no;
                $usercurrencyaccount->user_id = $data->id;
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
                $usercurrencyaccount->user_id = $data->id;
                $usercurrencyaccount->currency_id = $currency->id;
                $usercurrencyaccount->created_at = Carbon::now();
                $usercurrencyaccount->updated_at = Carbon::now(); 
                $usercurrencyaccount->save();
            }
        }

         // dd($this->crud->entry);
        $paymentgateway = new Paymentgateway;
        $paymentgateway->gatewayname = 'bank '.$currency_data->name;
        $paymentgateway->displayname = 'Bank Transfer '.$currency_data->name;
        $paymentgateway->active = 1;
        $paymentgateway->currency_id = $currency_data->id;
        $paymentgateway->withdraw = 1;
        $paymentgateway->exchange = 0;
        $paymentgateway->params = '{"bank_name":"bank_name_here", "bank_address":"bank_address_here", "swift_code":"swift_code_here", "account_name":"account_name_here", "account_no":"account_no_here"}';
        $paymentgateway->instructions = 'some instruction text';
        $paymentgateway->save();
            return true;
    }
    
    /**
     * Undocumented function
     *
     * @param [type] $account_name
     * @return void
     */
  
	
 }

