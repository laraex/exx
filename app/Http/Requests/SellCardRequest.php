<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Lang;

class SellCardRequest extends FormRequest
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
 

        Validator::extend('checksellamount', function ($attribute, $value, $parameters, $validator) {
         if (Input::get('amount')>Input::get('sell_card_amount'))
                   {
                        return FALSE;
                   }

                   
                   return TRUE;                        
             } );
      


       $rules=[
       'amount'=>'required|numeric|min:1',
       'sell_card_amount'=>'required|numeric|min:1|checksellamount',
       'title'=>'required',
       'description'=>'required',


       ];
        if (!is_null(Input::file('image')))
        {
            $rules['image'] = 'max:10000|mimes:png,jpg,jpeg';
        }


     
      return  $rules;
    }

    public function messages()
    {

       //
        return [
             'sell_card_amount.checksellamount'=>trans('forms.sell_card_amount_error'),
             
        ];
    }

}