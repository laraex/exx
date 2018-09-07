<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Authentication;
use Carbon\Carbon;
use Lang;

class OTPRequest extends FormRequest
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
        Validator::extend('checkotp', function ($attribute, $value, $parameters, $validator) 
        {
            $otp = Authentication::where([['user_id',Auth::id()],
                    ['status',0]])->orderBy('id','DESC')->get(); 
            $otp_token =  $otp[0]->token;             
            if($otp_token!=Input::get('otp'))
            {
                return FALSE;
            }
            return TRUE;            
        });

        Validator::extend('checkotp_ip', function ($attribute, $value, $parameters, $validator) 
        {
            $otp = Authentication::where([['user_id',Auth::id()],
                    ['status',0]])->orderBy('id','DESC')->get(); 
            $otp_ipaddress =  $otp[0]->ip_address; 
            if($otp_ipaddress!=$_SERVER['REMOTE_ADDR'])
            {
                return FALSE;
            }
            return TRUE;            
        });

        Validator::extend('checkotp_expiry', function ($attribute, $value, $parameters, $validator) 
        {
            $otp = Authentication::where([['user_id',Auth::id()],
                    ['status',0]])->orderBy('id','DESC')->get(); 
            $expires_on =  $otp[0]->expires_on; 
            if($expires_on<Carbon::now())
            {
                return FALSE;
            }
            return TRUE;            
        });

        return [
            'otp' => 'required|checkotp|checkotp_ip|checkotp_expiry',
        ];
    }

    public function messages()
    {
        return [
            'otp.checkotp' => trans('forms.error_otp'),
            'otp.checkotp_ip' => trans('forms.error_otp_ip'),
            'otp.checkotp_expiry' => trans('forms.error_otp_expiry'),
        ];
    }

}