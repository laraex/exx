<?php 

namespace App\Traits;

use App\User;
use App\Placement;
use App\Models\Userprofile;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Usercurrencyaccount;
use App\Traits\CoinProcess;
use App\Traits\Common;
use App\Models\Accountingcode;
use Exception;

trait UserInfo 
{
    use CoinProcess;
       /*   public function isUserProfileCompleted (user $user) {
      $user_id = $user->id;
                $userprofile = Userprofile::where('user_id', $user->id)->first();
                if ( is_null($userprofile->firstname) || is_null($userprofile->lastname) || is_null($userprofile->mobile) 
                    || is_null($userprofile->country)  || is_null($userprofile->ssn) || is_null($userprofile->kyc_doc) )
                    {
                        return false;
                    } else {
                         return true;
                    }
        }

        public function isKycApproved (user $user) {
            $user_id = $user->id;
                $userprofile = Userprofile::where('user_id', $user->id)->first();
                $kycApproved = $userprofile->kyc_verified;
                return $kycApproved;
        }

        public function isEmailVerified(user $user) {
            $user_id = $user->id;
                $userprofile = Userprofile::where('user_id', $user->id)->first();
                $emailVerified = $userprofile->email_verified;
                return $emailVerified;
        }

        public function isActive(user $user) {
            $user_id = $user->id;
                $userprofile = Userprofile::where('user_id', $user->id)->first();
                $active = $userprofile->active;
                return $active;
        }
*/
        public function isActive(user $user) {

            if(count($user->userprofile)>0)
                {
                  return $user->userprofile->active;
                }
                else
                {
                    return 1;
                }
        }

        public function isUserProfileCompleted (User $user) 
        {
            $user_id = $user->id;
            $userprofile = $user->userprofile;
            if(count($userprofile)>0)
            {
                if ( is_null($userprofile->firstname) || is_null($userprofile->lastname) || is_null($userprofile->mobile) || is_null($userprofile->country)  || is_null($userprofile->ssn) || is_null($userprofile->kyc_doc) )
                {
                    return false;
                } else {
                    return true;
                }
            }
            else
            {
                return false;
            }
        }
        // public function isKycApproved (user $user) {
        //         $userprofile = $user->userprofile;
        //         if(count($userprofile)>0)
        //         {
        //             $kycApproved = $userprofile->kyc_verified;
        //             if(($userprofile->kyc_verified)&&($userprofile->kyc_address_verified))
        //             {
        //                 return 1;
        //             }
        //             return 0;
        //         }
        //         else
        //         {
        //             return 0;
        //         }
        // }

        public function isKycApproved (user $user) 
        {
            $total=$this->totalKycApproved ($user); 
            $minkyc=\Session::get('min_kyc');
      
            if(isset($minkyc))
            {
                $min_kyc=\Session::get('min_kyc');
            }
            else
            {
                $min_kyc=$this->getSettingValue('min_kyc');
                $min_kyc=\Session::put('min_kyc',$min_kyc);
            }
          
            if($total>=$min_kyc)
            {
                return 1;
            }
            return 0;
        }

    public function isEmailVerified(user $user) 
    {
        $emailVerified=0;
        $userprofile = $user->userprofile;
        if(count($userprofile)>0)
        {
            $emailVerified = $userprofile->email_verified;
        }
        return $emailVerified;
    }
        /*public function getUserBalance(user $user)
        {
            // dd($user); 

            $allUserAccount = $user->useraccount->whereIn('currency_id', [1,2,3,4,5])->pluck('id')->toarray();
            // dd($allUserAccount);

           $creditTransactions = Transaction::whereIn('account_id' ,$allUserAccount)->where([
            ['type', 'credit'],
            ['deposit_status', 'active'],
            ['action', 'deposit'],
            ])->sum('amount');            

            $debitTransactions  = Transaction::whereIn(
                        'account_id' ,$allUserAccount)
                        ->where('type', '=', 'debit')->sum('amount');
             // dd($creditTransactions);
             $balance = $creditTransactions - $debitTransactions;

            return $balance;
        }
*/
      /*  public function getUserCurrencyBalance(user $user, $currency_id)
        {
             // dd($currency_id);
               
            $usercurrencyaccountid=$this->getAccountID($user->id,$currency_id);


            $creditTransactions = Transaction::where([
                ['account_id', $usercurrencyaccountid],
                ['type', 'credit'],
                ['status', 1],
                ])->whereIn('action', array('deposit', 'transfer', 'exchange','buygiftcardwallet','buycoin','withdraw','couponcode','externalexchange','buytrade'))->sum('amount');
            // print_r($creditTransactions);

            $debitTransactions  = Transaction::where(
                        'account_id' ,$usercurrencyaccountid)
                        ->where('type', '=', 'debit')->sum('amount');
            // print_r($debitTransactions);

            $balance = $creditTransactions - $debitTransactions;

            
  
            return $balance;

        }*///Imp
        public function getUserCurrencyBalance(user $user,$currency_id)
        {
            $balance=0;
                try{

                    $balance=$user->UserBalance[$currency_id];
                }
                catch(Exception $e)
                {

                }
                return $balance;

        }


        public function getUserBalanceByUser(user $user)
        {
             // dd($currency_id);

            $balance=Transaction::where('user_id',$user->id)->selectRaw("user_id,currency_id, SUM(case when type='credit' and action In('deposit','transfer','exchange','buygiftcardwallet','buycoin','withdraw','couponcode','externalexchange','buytrade','cashpoint','settlement','crypto-withdraw-cancel') and status='approve' then amount else 0 end) - SUM(case when type='debit' then amount else 0 end)  as balance")->groupBy('user_id','currency_id')->pluck('balance','currency_id');
            return $balance;

        }
        public function getPendingBalance($currencyid, $user_id)
        {
               // echo $user_id;
            $getid = Usercurrencyaccount::where([
                ['currency_id', '=', $currencyid],
                ['user_id', '=', $user_id]
                ])->get(['id'])->toArray();
            $usercurrencyaccountid = $getid[0]['id'];

            // echo $usercurrencyaccountid;


                $getPendingBalance  = Transaction::where(
                            'account_id', $usercurrencyaccountid)
                            ->where(
                            'deposit_status', 'new')
                            ->where(
                            'type', 'credit')
                            ->where(
                            'action', 'deposit')
                            ->sum('amount');

           

            return $getPendingBalance;
        }


        private function getUplines(int $totalLevelsForCommission ) {
            
                        $placement = $this->placement;

                        $alphaKey = $placement->alphakey;
                        $uplines = [];
                        if($alphaKey!='A')
                        {
            
                            $uplineKey=explode('-',$alphaKey);
                            $uplineKeyLength=count($uplineKey);
                
                
                
                            if ($uplineKeyLength >= $totalLevelsForCommission) {
                                $uplineCount = $totalLevelsForCommission;
                            }else {
                                $uplineCount = $uplineKeyLength;
                            }
                           
                
                
                            $root_user_id=Placement::where([['alphakey', 'A'],['root_id',0],['spillover_id',0]])->pluck('user_id'); 
                
                            $userid=explode('-B',$alphaKey);
                            $userid = array_diff($userid,[$this->id]);//For Deposit User-Remove
                            $userid = array_diff($userid, ["A"]);//For Root User Key-Remove
                            array_unshift($userid ,$root_user_id[0]);//For Root User -Add
                
                            $uplines = Placement::whereIn('user_id', $userid )->orderby('user_id','DESC')->pluck('user_id')->take($uplineCount)->toarray(); 
                             
                            //$uplines = User::whereIn('id', $userid )->orderby('id','DESC')->take($uplineCount)->get(); 
                        }
                        
                        return $uplines;
                
                }

    public function totalKycApproved (user $user) 
    {
        $userprofile = $user->userprofile;
        $i=0;
        if(count($userprofile)>0)
        {
            $passport_verified = $userprofile->passport_verified;
            $id_card_verified = $userprofile->id_card_verified;
            $driving_license_verified = $userprofile->driving_license_verified;
            $photo_id_verified = $userprofile->photo_id_verified;
           // $bank_verified = $userprofile->bank_verified;
            if($passport_verified==1)
            {
                $i++;
            }
            if($id_card_verified==1)
            {
                $i++;
            }
            if($driving_license_verified==1)
            {
                $i++;
            }
            if($photo_id_verified==1)
            {
                $i++;
            }
           /* if($bank_verified==1)
           {
            $i++;
           }*/
        }
        return $i;
   
    }
    
 }