<?php

namespace App\Http\Requests;
 
use Lang;
use Session;
use Illuminate\Support\Facades\Input;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class MessageRequest extends FormRequest
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
        Validator::extend('checkmessage', function ($attribute, $value, $parameters, $validator) 
        {   
           return preg_match('/[A-Za-z0-9_~\-!@#\$%\^&*.:(\)\s\p{L}\p{M}*]+$/u',Input::get('message')); 
         
        });               
        $rules = [
           'send_to'=>'required',
           'message'=> 'required|checkmessage',    
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

        $message = [
            'send_to.required' => trans('forms.sendtoreq'),
            'message.required' => trans('forms.messagereq'),
            'message.checkmessage'=>trans('forms.checkmessage'),
        ];
        return $message;
    }
    

}
