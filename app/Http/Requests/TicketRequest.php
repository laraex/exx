<?php

namespace App\Http\Requests;
 
use Lang;
use Session;
use Illuminate\Support\Facades\Input;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class TicketRequest extends FormRequest
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
           return preg_match('/[A-Za-z0-9_~\-!@#\$%\^&*.:(\)\s\p{L}\p{M}*]+$/u',Input::get('description')); 
         
        });               
        $rules = [
            'subject'      => 'required',
           'description'      => 'required|checkmessage',    
        ];

        $files = count($this->input('attachments')) - 1;
            foreach(range(0, $files) as $index) {
            $rules['attachments.' . $index] = 'mimes:png,jpeg,jpg,pdf';        
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

        $message = [
           'subject.required'      => trans('forms.subjectreqmsg'),
            'description.required'      => trans('forms.descriptionreqmsg'),
            'description.checkmessage'=>trans('forms.checkmessage'),

        ];
        
        $files = count($this->input('attachments'));
            foreach(range(0, $files) as $index) {
            $message['attachments.' . $index] = trans('forms.mimecheck');
            Session::flash('mimecheck', $message['attachments.' . $index]);           
         return $message;
        }
        
        return $message;
    }
    

}
