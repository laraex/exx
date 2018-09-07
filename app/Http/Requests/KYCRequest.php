<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\User;
use App\Traits\UserInfo;

class KYCRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    use UserInfo;
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
         $i=0;              

        if(Input::get('passport')==1)
        {
          $rules['passport_attachment'] = 'required|max:10000|mimes:png,jpg,jpeg';
          $i++;
        }
        if(Input::get('id_card')==1)
        {
          $rules['id_card_attachment'] = 'required|max:10000|mimes:png,jpg,jpeg';
          $i++;
        }
        if(Input::get('driving_license')==1)
        {

          $rules['driving_license_attachment'] = 'required|max:10000|mimes:png,jpg,jpeg';
          $i++;
        }
        if(Input::get('photo_id')==1)
        {

           $rules['photo_id_attachment'] = 'required|max:10000|mimes:png,jpg,jpeg';
           $i++;
        }
        $user=User::find(Auth::id());
        $totalapproved=$this->totalKycApproved($user);

        $total= $i-$totalapproved;
        $min_kyc=$this->getSettingValue('min_kyc');

     if((($total!=0)||($totalapproved==0))&&($i<$min_kyc))
       // if(($total!=0)&&($i<$min_kyc))
        {
             $rules['verification'] = 'required';
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

        return ['verification.required'=>trans('forms.verification_min_error')];
    }
}
