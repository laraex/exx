<?php

namespace App\Http\Requests;

use Lang;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class FundConfirmRequest extends FormRequest
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
       

       Validator::extend('checkamount', function ($attribute, $value, $parameters, $validator) {
             if (Input::get('depositamount')<=0)
                   {
                        return FALSE;
                   }

                   
                   return TRUE;  
                        
             } );

        $rules = [
            'depositamount' => 'required|numeric',
            'comment' => 'required',
        ];     

      
        

        
       // dd($rules);

        return $rules;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {

        return [
            
            'depositamount.required' => trans('forms.amountrequired'), 
            'comment' => trans('forms.comment_req'),
            
        ];
    }

}
