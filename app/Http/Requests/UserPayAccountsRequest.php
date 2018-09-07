<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class UserPayAccountsRequest extends FormRequest
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
       'bank_name'=>'required',
       'swift_code'=>'nullable|alpha_num',
       'account_no'=>'required|numeric',
       'account_name'=>'required',
       'account_address'=>'required',
       ];

       return $rules;
    }

    public function messages()
    {
        $messages = [];

        return $messages;
    }

}
