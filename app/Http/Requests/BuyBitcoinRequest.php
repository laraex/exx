<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Lang;
use App\Traits\CoinProcess;
use App\Models\Currency;
use App\Coinorder;




class BuyBitcoinRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    use CoinProcess;
    public function authorize()
    {

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

  
    

        Validator::extend('checkbitcoinhash', function ($attribute, $value, $parameters, $validator) {
                 $checktxnhashkey = Coinorder::where('bitcoin_hash_id', Input::get('bitcoin_hash_id'))->exists();  
               

                   if ($checktxnhashkey)
                   {
                        return FALSE;
                   }
                   return TRUE;            
                      });


        Validator::extend('checkvalidhashkey', function ($attribute, $value, $parameters, $validator) {
                 
                 $response_json = $this->getBitcoinDetails(Input::get('bitcoin_hash_id'));

               

                              
               if (is_null($response_json))
               {
                    return FALSE;
               }
                   return TRUE;            
             } ); 



         $rules['bitcoin_hash_id']='required|checkbitcoinhash|checkvalidhashkey';
    
    return  $rules;
    }

    public function messages()
    {

       //
        return [
       
            'bitcoin_hash_id.checkbitcoinhash' => trans('forms.hashkey_error'),
            'bitcoin_hash_id.checkvalidhashkey' => trans('forms.invalid_hashkey'),
            
        ];
    }

}