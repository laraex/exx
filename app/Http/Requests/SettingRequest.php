<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Placement;
use App\CurrencyMaster;
use App\Settings;
class SettingRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
     
             return [];
            }
            case 'PUT':
            {
                $id=Input::get('id');
                $settings=Settings::where('id', $id)->first();
                $rules=[];
                        
                if($settings->key=='default_sponsor')
                {
                    $count_place='';
                  
                    Validator::extend('checkuser', function ($attribute, $value, $parameters, $validator) {

                        $user=User::where('email', Input::get('value'))->get();

                        $count  = $user->count();

                        if($count>0)
                        {
                           $count_place = Placement::where('user_id',$user[0]->id)->get()->count();
                        } 
                           
                            if(($count==0)||($count_place==0))
                               {
                                    return FALSE;
                               }
                               return TRUE;            
                            });

                  $rules['value']='required|checkuser';
                }

                if($settings->key=='currency')
                {
                    Validator::extend('checkcurrency', function ($attribute, $value, $parameters, $validator) 
                    {
                        $currency=CurrencyMaster::where('symbol', Input::get('value'))->exists();

                        if($currency)
                        {
                            return TRUE;
                        }
                            return FALSE ;            
                    });

                    $rules['value']='required|checkcurrency';
                }

                if ($settings->key == 'matrix_width' || $settings->key == 'pagecount' || $settings->key == 'withdraw_min_amount' || $settings->key == 'withdraw_max_amount' || $settings->key == 'monthly_withdraw_limit' || $settings->key == 'daily_withdraw_limit' || $settings->key == 'fundtransfer_min_amount' || $settings->key == 'fundtransfer_max_amount' || $settings->key == 'fundtransfer_commission' || $settings->key == 'exchange_commission' || $settings->key == 'BTC-reserve-amount-buy' || $settings->key == 'BTC-commission-buy' || $settings->key == 'LTC-reserve-amount-buy' || $settings->key == 'LTC-commission-buy' || $settings->key == 'DOGE-reserve-amount-buy' || $settings->key == 'DOGE-commission-buy' || $settings->key == 'min_kyc') 
                {
                     $rules['value']='required|numeric';
                }
                return $rules;

            }
            case 'PATCH':        
            default:break;
        }
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {

        $messages=[
            'value.checkuser' => trans('admin.checkuser'),            
            'value.checkcurrency' => trans('admin.checkcurrency'),            
                       
        ];
        return $messages;
       
    }
}
