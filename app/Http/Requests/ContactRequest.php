<?php

namespace App\Http\Requests;
 
use Lang;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
         
        Validator::extend('checkname', function ($attribute, $value, $parameters, $validator) 
        {
            return preg_match('/^[A-Za-z0-9_~\-!@#\$%\^&*.:(\)\s]+$/',Input::get('fullname'));
        });

        // Validator::extend("checkmail", function($attribute,$value,$parameters,$validator)
        // {
        //     return preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i',Input::get('emailid'));
        // });
         

        $rules = [
            'fullname' => 'required|regex:/^[\pL\s\-]+$/u|between:6,25|checkname',
            'emailid' => 'required|email',
            'contactno' => 'required|regex:/[0-9]{2}[0-9]{8}/|max:15',  
            'message' => 'required|checkmessage'
        ];

        if (\Config::get('settings.contactus_captcha_status') == '1' && Auth::id() == '') 
        {
            $rules['g-recaptcha-response'] = 'required';
           
        } 

       
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
            'fullname.required' => trans('forms.name_req'),   
            'emailid.required' => trans('forms.emailid_req'),
            'contactno.required' => trans('forms.contactno_req'),   
            'message.required' => trans('forms.query_req'),
            'message.checkmessage'=>trans('forms.checkmessage'),
            'emailid.email' => trans('forms.validemail'),
            'contactno.numeric' => trans('forms.contactnonumeric'),
            //'contactno.min' => trans('forms.contactnomin'),
           // 'contactno.max' => trans('forms.contactnomax'),
           'g-recaptcha-response.required' => 'Captcha is required',
        ];
    }

}
