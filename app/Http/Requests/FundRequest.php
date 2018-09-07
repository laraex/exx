<?php

namespace App\Http\Requests;

use Lang;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class FundRequest extends FormRequest
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
       

       Validator::extend('checkamount', function ($attribute, $value, $parameters, $validator) {
             if (Input::get('amount')<=0)
                   {
                        return FALSE;
                   }

                   return TRUE;  
                        
             });

          Validator::extend('checkfloatpoint', function ($attribute, $value, $parameters, $validator) {

            //dd("GG");

                 

                   // if(!$inte==1){

                         //echo "Intssss".$inte;

           $val=(float)Input::get('amount');
         
           $float=is_float($val);

              
                        if($float==1) {
                              
                                $poinval=explode('.',Input::get('amount'));

                                if(count($poinval)==2) {
                                $numlength = strlen((string)$poinval[1]);
                                if($numlength>2){
                                   return FALSE;
                                   
                                }
                            }
                        }

                   return TRUE;  
                        
             });



        $rules = [

            'amount' => 'required|checkfloatpoint|checkamount',

            'paymentgateway' => 'required',
        ];     

      
        

        
       // dd($rules);

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
            'plan.required' => trans('forms.plan_req'),  
            'amount.required' => trans('forms.amountrequired'), 
            'amount.checkfloatpoint'=>trans('forms.twodigits'),
            'paymentgateway.required' => trans('forms.payment_req'),
            'amount.checkamount'=>trans('forms.amount_error'),
            
        ];
    }

}
