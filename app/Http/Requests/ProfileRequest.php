<?php

namespace App\Http\Requests;
 
use Lang;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Userprofile;
use Validator;

class ProfileRequest extends FormRequest
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
        $userprofile = Userprofile::where('user_id', Auth::id() )->first();       

        $rules = [
            'firstname' => 'required|regex:/^[\pL\s\-]+$/u|between:6,25', 
            'lastname' => 'required|regex:/^[\pL\s\-]+$/u|between:2,25', 
            'country' => 'required', 
        ];        

        if (!is_null(Input::get('city')))
        {
            $rules['city'] = 'regex:/^[\pL\s\-]+$/u';
        }

        if (!is_null(Input::get('state')))
        {
            $rules['state'] = 'regex:/^[\pL\s\-]+$/u';
        }

         if ($userprofile->mobile_verified == 0)
        {
            Validator::extend('checkmobilenumber', function ($attribute, $value, $parameters, $validator) {                  
                   if ( strlen(Input::get('mobile')) < 10 || strlen(Input::get('mobile')) > 15)
                   {
                        return FALSE;
                   }
                   return TRUE;            
            });    
            $rules['mobile'] = 'required|numeric|checkmobilenumber';
        }

        if ($userprofile->kyc_verified == 0 || $userprofile->kyc_verified == 2)
        {
            $rules['kyc_doc'] = 'max:10000|mimes:png,jpg,jpeg';
        }

        if (\Config::get('settings.kyc_required_status') == 1)
        {
            $rules['kyc_doc'] = 'required';
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
            'firstname.required' => trans('forms.first_name_req'), 
            'firstname.between' => trans('forms.first_name_between'), 
            'firstname.regex' => trans('forms.first_name_regex'),
            'lastname.regex' => trans('forms.last_name_regex'),
            'lastname.between' => trans('forms.last_name_between'), 
            'lastname.required' => trans('forms.last_name_req'), 
            'mobile.required' => trans('forms.mobile_no_req'),
            'mobile.numeric' => trans('forms.mobile_no_numeric'), 
            'mobile.checkmobilenumber' => trans('forms.mobile_check_isvalid'), 
            'country.required' => trans('forms.country_req'),  
            'city.regex' => 'The City allows only characters',
            'state.regex' => 'The State allows only characters'
        ];
    }
}
