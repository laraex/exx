<?php
/**
 * Trait for processing common
 */
namespace App\Traits;

use App\CurrencyPair;
use App\Models\Currency;
use App\CurrencyMaster;
/**
 *
 * @class trait
 * Trait for Common Processes
 */
trait CurrencyPairProcess
{
    /**
     * Getting a Value from Settings
     *
     * @param [type] $key
     * @return string
     */
    public function createCurrencyPair($currency_data)
    {
        
        $list=Currency::where([['type','crypto'],['id','!=',$currency_data->id]])->orderby('id','asc')->get();

        
            foreach($list as $key=>$value)
            {
                

                $create=[  

                        'from_currency_id'=>$value->id,
                        'to_currency_id'=>$currency_data->id,
                                                                          
                      ];

                CurrencyPair::create($create);
            }
        
            $this->updateCurrencyMaster($currency_data);
            return true;
    }
    public function updateCurrencyPair($currency_data)
    {
        $list=CurrencyPair::where('to_currency_id',$currency_data->id)->orderby('id','asc')->get();

      //  if(($currency_data->type=='fiat')&&($currency_data->status==0))
        if($currency_data->status==0)
        {
            foreach($list as $key=>$value)
            {
                

                $update=[ 

                        'status'=>'inactive',
                                                                                                 
                      ];

                CurrencyPair::where('id',$value->id)->update($update);
            }
        }

            return true;
    }

    public function updateCurrencyMaster($currency_data)
    { 

                $update=[ 

                        'status'=>'used',
                                                                                                 
                      ];

                CurrencyMaster::where('symbol',$currency_data->name)->update($update);
            
        

            return true;
    }
    /**
     * Undocumented function
     *
     * @param [type] $account_name
     * @return void
     */
  
	
 }

