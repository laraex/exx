<?php

namespace App\Http\Requests;

use App\Models\Withdraw;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class WithdrawOtpRequest extends FormRequest
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

         Validator::extend('checkotpcode', function ($attribute, $value, $parameters, $validator) {         
                   $result  = Withdraw::where([
                                        ['param1', '=', Input::get('otpcode')],
                                        ['id', '=', Input::get('withdrawid')]
                                        ])->exists();
                   //dd($result);
                   if (!$result)
                   {
                        return FALSE;
                   }
                   return TRUE;            
        });  

    
               
        $rules = [
            'otpcode' => 'required|checkotpcode',
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

        return [
            'otpcode.required' => trans('forms.otpcoderequired'),   
            'otpcode.checkotpcode' => trans('forms.checkotpcode'),        
        ];
    }

}
