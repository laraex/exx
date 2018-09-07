<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Lang;
use App\Traits\UserInfo;
use App\Models\Giftcard;
use App\User;




class BuyGiftCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    use UserInfo;
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

      
      
       Validator::extend('checkbalance', function ($attribute, $value, $parameters, $validator) {
        $id=\Session::get('giftcard_id');
        $giftcard= Giftcard::where([['active', true],['id',$id]])->get();

         $user=User::find(Auth::id());
         $currency_id=$this->getCurrencyId(USER_BUY_GIFTCARD_CURRENCY);
         $balance=$this->getUserCurrencyBalance($user, $currency_id);

       

                 
                   if ($giftcard[0]->buyprice>$balance)
                   {
                        return FALSE;
                   }
                   return TRUE;  
                        
             } );


     
        $rules['balance']='checkbalance';
    


   



      return  $rules;
    }

    public function messages()
    {

       //
        return [
             
             'balance.checkbalance'=>trans('forms.errorbalance'),
            
        ];
    }

}