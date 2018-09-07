<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Validator;

class KYCFinancialRequest extends FormRequest
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
          'bank_attachment' => 'required|max:10000|mimes:png,jpg,jpeg',       
          'bank_name'=> 'required',
          'country'=> 'required',
          'statement' => 'required|date',
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
