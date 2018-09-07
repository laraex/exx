<?php

namespace App\Http\Requests;

use App\Models\Userpayaccounts;
use App\Models\Userprofile;
use App\Traits\UserInfo;
use App\User;
use Exception;
use Hash;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class XRPSendRequest extends FormRequest
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
        Validator::extend('checkaddress', function ($attribute, $value, $parameters, $validator) {
            $pg = $this->getPgDetailsByGatewayName('xrp');
            $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->count();
            if ($user_accounts == 0) {
                return false;
            }
            return true;
        });
        

        Validator::extend('checkamount', function ($attribute, $value, $parameters, $validator) {
            if (Input::get('amount') <= 0) {
                return false;
            }
            return true;
        });

        Validator::extend('checkuserbalance', function ($attribute, $value, $parameters, $validator) {
            $pg = $this->getPgDetailsByGatewayName('xrp');
            $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->first();
            $balance = 0;
            $user = User::where('id', Auth::id())->first();
                    $balance = $this->getUserCurrencyBalance($user, $pg->currency_id);
            if (count($user_accounts) > 0) {
                if ($user_accounts->xrp_address != '') {
                    $user = User::where('id', Auth::id())->first();
                    $balance = $this->getUserCurrencyBalance($user, $pg->currency_id);
                    // $balance=$this->getWalletBalance($user_accounts->btc_address);

                }
            }
            \Session::put('xrperror', '');

            $amount =  Input::get('amount');
            $total = 0;

            //$to_btc_address= $params['btc_address'];
            $to_xrp_address = Input::get('address');

            try
            {

                // $fee= CryptoPaymentBase::crypto_calculateBTCAdminFee($amount);
                $fee = $pg->crypto_withdraw_fee;
                $base_fee = $pg->crypto_withdraw_base_fee;

                $fee_total = ($amount * ($fee / 100)) + $base_fee;

                $total = $fee_total + $amount;
                if ($balance < $total) {
                    return false;
                } else {
                    return true;
                }
            } catch (Exception $e) {
                $xrperror = $e->getMessage();
                \Session::put('xrperror', $xrperror);
                return false;
            }
        });

        Validator::extend('checkvalidpassword', function ($attribute, $value, $parameters, $validator) {

            $userprofile = Userprofile::where('user_id', Auth::id())->pluck('transaction_password');
            //dd($userprofile[0]);

            if (!Hash::check(Input::get('transaction_password'), $userprofile[0])) {
                return false;
            }
            return true;
        });

        $rules = [
            'amount' => 'sometimes|numeric|checkamount|checkuserbalance|required',
            'address' => 'required',
            'transaction_password' => 'required|checkvalidpassword',
        ];
        return $rules;
    }
    public function messages()
    {
        $messages = [
            'amount.checkamount' => trans('forms.amount_error'),
            'amount.checkaddress' => trans('forms.xrp_address_error'),
            'transaction_password.checkvalidpassword' => trans('forms.checkvalidpassword'),
        ];

        if (\Session::get('xrperror') != '') {
            $messages['amount.checkuserbalance'] = \Session::get('xrperror');

        } else {
            $messages['amount.checkuserbalance'] = trans('forms.errorbalance');
        }

        return $messages;
    }
    
   
}
