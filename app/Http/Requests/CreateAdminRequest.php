<?php

namespace App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class CreateAdminRequest extends FormRequest
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

         $rules = [        
            'name' => 'required|min:6|max:12|unique:users',
            'email' => 'required|email|max:255|unique:users',           
            'password' => 'required|min:6|confirmed', 
            'password_confirmation' => 'required|min:6',   
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

        return [];
       //
    }

}
