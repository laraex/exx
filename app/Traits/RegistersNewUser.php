<?php 

namespace App\Traits;

use App\User;
use App\Settings;
use App\Models\Userprofile;
use Carbon\Carbon;
use App\Models\Currency;
use App\Models\Usercurrencyaccount;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;
// use App\Mail\CreateNewUser;
// use Illuminate\Bus\Queueable;
use App\Traits\Common;
use App\Classes\block_io\BlockIo;
use App\Traits\PayaccountsProcess;
use App\Events\CreateWallet;
use Event;
use App\UserInformation;
use App\Http\Controllers\CryptoPayment\CryptoPaymentBase;
use App\Traits\CashpointsProcess;
use Gegosoft\Rippled\Client;

trait RegistersNewUser 
{
    use PayaccountsProcess;

    public function getSponsorId($username) {

       /* $defaultSponsorSettings = Settings::where('key', 'default_sponsor')->first();
        $defaultSponsor = User::where('email', $defaultSponsorSettings->value)->first();

        $checkSponsorInCookie = Cookie::get('sponsor');

        $checkSponsorInCookieExists = User::where('name', $checkSponsorInCookie)->exists();
        if (is_null($defaultSponsor) || !$checkSponsorInCookieExists ) {
            $sponsorId = $defaultSponsor->id;
        }else {
            $sponsorId = User::where('name', $checkSponsorInCookie)->first()->id;
        }*/
        if($username=='')
        {

         $default_sponsor=$this->getSettingValue('default_sponsor');  
         $root  = User::where('email', $default_sponsor)->first();
         $sponsorId = $root->id;
        }
        else
        {
          $sponsorId = User::where('name', $username)->first()->id;
        }

   

        return $sponsorId;
    }


	public function createuserprofile($user) 
	{   
        $emailcode = str_random(30);

        $userprofile = new Userprofile;
        $userprofile->user_id = $user->id;
        $userprofile->usergroup_id = 3;
        $userprofile->email_verification_code = $emailcode;
        $userprofile->created_at = Carbon::now();
        $userprofile->updated_at = Carbon::now(); 
        $userprofile->save();
         $this->createCurrencyAccount($user); 
        // Event::fire(new CreateWallet($user));
         $this->createUserInformation($user); 
         $this->usertransaction($user);
        return $userprofile;       
	}

    public function admincreateuserprofile($user, $request) 
    {   
        $emailcode = str_random(30);

        $userprofile = new Userprofile;
        $userprofile->user_id = $user->id;
        $userprofile->usergroup_id = $request->usergroup;
        $userprofile->email_verified = 1;
        $userprofile->created_at = Carbon::now();
        $userprofile->updated_at = Carbon::now(); 
        if ($request->usergroup == 3)
        {
           $usercurrencyaccount = $this->createCurrencyAccount($user); 
           // Event::fire(new CreateWallet($user)); 
           $this->createUserInformation($user);
        }        
        if ($userprofile->save())
        {   

            session()->flash('successmessage', 'User Created Successfully');
            return TRUE;
        }
        else
        {
            session()->flash('errormessage','User Created  Failed!!!.');
            return FALSE;
        }       
    }

    public function createCurrencyAccount($user) 
    {
        $currencies = Currency::where('status', '1')->get();

        foreach ($currencies as $currency)
        {
            $account_no = "U-".$currency->name."-".(10000 + $user->id );

            $usercurrencyaccount = new Usercurrencyaccount;
            $usercurrencyaccount->account_no = $account_no;
            $usercurrencyaccount->user_id = $user->id;
            $usercurrencyaccount->currency_id = $currency->id;
            $usercurrencyaccount->created_at = Carbon::now();
            $usercurrencyaccount->updated_at = Carbon::now(); 
            $usercurrencyaccount->save();
        }

    }
    public function usertransaction($user)
    { 
       $currencies = Currency::get();

        foreach ($currencies as $currency)
        {
          $array=[];

             $transaction=$this->createTransaction($user->id,$currency->id,0,"credit","approve","NULL","NULL","initial","NULL","NULL",$user->id,get_class($user),0,0,"NULL","NULL",$array);
        }

     }
   

     public function createDOGEWalletAddress($user,$label)
    {
        $pg = $this->getPgDetailsByGatewayName('dogecoin_blockio');
        $params = json_decode($pg->params, true);
        $api_key= $params['api_key'];
        $pin= $params['pin'];
        $version = $params['version']; // API version
        $block_io = new BlockIo($api_key, $pin, $version);
        $address='';
        try
        {
            $walletaddress = $block_io->get_new_address(array('label' => $label));
            $address = $walletaddress->data->address;
        }
        finally
        {
            return $address;
        }
    }
   

    

    public function createBTCWallet($user)
    {

        $response = CryptoPaymentBase::crypto_createBTCAddress($user);

         if($response['address']!='')
         {
             $pg_btc = $this->getPgDetailsByGatewayName('bitcoin_blockio');
                 $request_btc = [
                'label' =>$response['label'] ,
                'btc_address' => $response['address'],
                'paymentid' => $pg_btc->id,
                
              ];
              $request_btc = (object) $request_btc;
              

            $this->bitcoinWallet($request_btc,$user->id,1,1,$pg_btc->currency_id); 
         }

        return $response['address'];


    }
    public function createLTCWallet($user)
    {
       $response=CryptoPaymentBase::crypto_createLTCAddress($user);

        if($response['address']!='')
        {
            $pg_ltc = $this->getPgDetailsByGatewayName('ltc_blockio');
                 $request_ltc = [
                'label' => $response['label'],
                'ltc_address' => $response['address'],
                'paymentid' => $pg_ltc->id,
                
              ];
            $request_ltc = (object) $request_ltc; 
            $this->ltcWallet($request_ltc,$user->id,1,1,$pg_ltc->currency_id); 
        }

        

        return $response['address'];
    }

    public function createDOGEWallet($user)
    {
        $label=$user->name."-".date('Y-m-dH-i-s');

        $doge_address=$this->createDOGEWalletAddress($user,$label);

        if($doge_address!='')
        {
          
            $pg_doge = $this->getPgDetailsByGatewayName('dogecoin_blockio');
            //dd($pg_doge);
                $request_doge = [
                    'label' => $label,
                    'doge_address' => $doge_address,
                    'paymentid' => $pg_doge->id,
                    'currency_id'=>$pg_doge->currency_id,
                ];
            $request_doge = (object) $request_doge; 

            $this->dogeWallet($request_doge,$user->id,1,1); 
        }
        return $doge_address;
    }

    public function createUserInformation($user) 
    {   
        $userinformation = new UserInformation;
        $userinformation->user_id = $user->id;
        $userinformation->created_at = Carbon::now();
        $userinformation->updated_at = Carbon::now();        
        $userinformation->save();              
    }
       public function createETHWallet($user)
    {
         $eth_passphrase=$this->randomString();
         $response=CryptoPaymentBase::crypto_createETHAddress($user,$eth_passphrase);
        if($response['address']!='')
        {
            $pg_eth = $this->getPgDetailsByGatewayName('eth');
                 $request_eth = [
                'eth_passphrase' => $eth_passphrase,
                'eth_address' => $response['address'],
                'paymentid' => $pg_eth->id,
                
              ];
            $request_eth = (object) $request_eth; 
            $this->ethWallet($request_eth,$user->id,1,1,$pg_eth->currency_id); 
        }

        

        return $response['address'];

    }

    public function createBCHWallet($user)
    {

        $response = CryptoPaymentBase::crypto_createBCHAddress($user);
         // dd($response);
         if($response['address']!='')
         {
             $pg_bch = $this->getPgDetailsByGatewayName('bch');
                 $request_bch = [
                'label' =>$response['label'] ,
                'bch_address' => $response['address'],
                'paymentid' => $pg_bch->id,
                
              ];
              $request_bch = (object) $request_bch;
              

            $this->bitcoincashWallet($request_bch,$user->id,1,1,$pg_bch->currency_id); 
         }

        return $response['address'];


    } 
    public function createXRPWallet($user,$address,$secret)
    {

        //  // dd($response);
         if($address!='')
         {
             $pg_bch = $this->getPgDetailsByGatewayName('xrp');
                 $request_xrp = [
                'xrp_secret' =>$secret,
                'xrp_address' => $address,
                'paymentid' => $pg_bch->id,
                
              ];
              $request_xrp = (object) $request_xrp;
              
              $this->xrpWallet($request_xrp,$user->id,1,1,$pg_bch->currency_id); 
         }
         $address = [
            'address' =>$address,
            'xrp_address' => getenv('XRP_ADDRESS'),
            'xrp_secret' => getenv('XRP_SECRET'),
            
          ];
        return $address;
    }
    public function createQTUMWallet($user)
    {

        $response = CryptoPaymentBase::crypto_createQTUMAddress($user);
         if($response['address']!='')
         {
             $pg_qtum = $this->getPgDetailsByGatewayName('qtum');
                 $request_qtum = [
                'label' =>$response['label'] ,
                'qtum_address' => $response['address'],
                'paymentid' => $pg_qtum->id,
                
              ];
              $request_qtum = (object) $request_qtum;
              

            $this->qtumWallet($request_qtum,$user->id,1,1,$pg_qtum->currency_id); 
         }

        return $response['address'];


    }
 }