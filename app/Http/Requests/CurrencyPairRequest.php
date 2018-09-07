<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Lang;

class CurrencyPairRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
   

 
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

         $rules=[
           'min_amount'=>'numeric',
           'max_amount'=>'numeric|min:'.Input::get('min_amount'),
           'exchange_rate_variant'=>'numeric',
           'buy_fee'=>'numeric',
           'buy_base_fee'=>'numeric',
           'sell_fee'=>'numeric',
           'sell_base_fee'=>'numeric',
           ];

       


      return  $rules;
    }

    public function messages()
    {

       //
        $messages=[];

        return $messages;
    }

}