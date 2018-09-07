<?php

namespace App\Http\Requests;
 
use Lang;
use Illuminate\Support\Facades\Input;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
               
        return [
            'oldpassword' => 'required', 
            'newpassword' => 'required|min:6', 
            'confirmpassword' => 'required|min:6|same:newpassword'              
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {      

        return [
            'oldpassword.required' => trans('forms.oldpassword_req'), 
            'newpassword.required' => trans('forms.newpassword_req'), 
            'confirmpassword.required' => trans('forms.confirmpassword_req'),
            'oldpassword.min' => trans('forms.oldpassword_min'),
            'newpassword.min' => trans('forms.newpassword_min'),
            'confirmpassword.min' => trans('forms.confirmpassword_min'),
            'confirmpassword.same' => trans('forms.confirmpassword_same')              
        ];
    }

}
