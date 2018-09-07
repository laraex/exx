<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Crypt;
use Google2FA;
use App\User;
use Illuminate\Support\Facades\Auth;
use Cache;
use Illuminate\Support\Facades\Validator;

class EditProfile2FARequest extends FormRequest
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
        Validator::extend('valid_token', function ($attribute, $value, $parameters, $validator) {
                $user = User::where('id', Auth::id())->first(); 
               // dd($user->google2fa_secret);     
                $secret = Crypt::decrypt($user->google2fa_secret);
               // dd($secret);
                return Google2FA::verifyKey($secret, $value);
            },
            'Not a valid token'
        ); 

        Validator::extend('used_token', function ($attribute, $value, $parameters, $validator) {
                $user = User::where('id', Auth::id())->first();
                $key = $user->id . ':' . $value;
                //dd($key);
                return !Cache::has($key);
            },
            'Cannot reuse token'      
        );   

        $rules = [
            'totp' => 'bail|required|digits:6|valid_token|used_token',
        ];     
        return $rules;
    }

    public function messages()
    {
        return [
            //
        ];
    }

}
