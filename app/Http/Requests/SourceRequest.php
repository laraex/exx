<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Validator;

class SourceRequest extends FormRequest
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

             'status'=> 'required',
             'title'=> 'required',
             'name'=> 'required',
             'state'=> 'required',
             'district'=> 'required',
             'street'=> 'required',
             'source'=> 'required',
             'net_amount'=> 'required',
             'industry'=> 'required',
             'country'=> 'required',
             'city'=> 'required',
             'number'=> 'required',
             'zipcode'=> 'required|numeric',
             'investment'=> 'required',
             'invest_stock'=> 'required',
             'investment_exp'=> 'required|numeric',
             'investment_exp_market'=> 'required|numeric',
             'derivative'=> 'required',
             'crypto_currencies'=> 'required',

             ];
       

        
        return $rules;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {      

        return [ ];
    }
}
