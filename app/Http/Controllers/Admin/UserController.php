<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Userprofile;
use App\Models\Activitylog;
use App\Models\Exchange;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Notifications\User\KycVerify;
use App\Notifications\User\KycRejected;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\Mail\KYCApprove;
use App\Mail\KYCReject;
use App\Mail\ResetUserTransactionPassword;
use App\Traits\UserInfo;
use App\Models\Usercurrencyaccount;
use App\Models\Fundtransfer;
use App\Models\Currency;
use App\Models\Transaction;
use Validator;
use App\Traits\RegistersNewUser;
use DB;
use Hash;
use Carbon\Carbon;
use App\Models\Userpayaccounts;
use App\Models\Paymentgateway;
use App\Models\Referralgroup;
use Illuminate\Support\Facades\Input;
use App\Models\Blockedusername;
use App\GiftcardOrder;
use Config;
use App\ExternalExchange;
use App\Coinorder;
use App\Mail\EmailVerification;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use App\Placement;
use App\Testimonial;
use App\Models\Ticket;
use App\Useraccount;
//use App\Withdraw;
use App\Interest;
use Illuminate\Pagination\Paginator;
use App\Mail\SendMailToUser;
use App\SendMail;
use App\Http\Requests\SendMailRequest;
use App\UserInformation;
use App\Traits\LogActivity;
use App\Transfer;
use App\TradeOrders;
use App\Models\Withdraw;

class UserController extends Controller
{
    
   public function __construct()
    {
        $this->middleware(['auth','admin1']);
    }

    use UserInfo, RegistersNewUser,LogActivity;

    public function index()
    {    
      
      //$userprofileverified = Userprofile::where('user_id',1)->get();
      //dd($userprofileverified[0]->passport_verified);
       
      $totalusers = User::ByUserType('3')->count(); 
      $user = User::ByUserType('3')->with('userprofile');
      //dd($user ->get());
     //dd($user);
      $q = Input::get('q');
      $verified = Input::get('verifiedbutton');
      $emailverified = Input::get('emailquery');
      //$kycverified = Input::get('kycquery');
      //dd($kycverified);

        if($q != "")
        {
          //dd('si');
            $users = $user->where('name', 'LIKE', '%' . $q . '%' )->orWhere('email', 'LIKE', '%' . $q . '%' )->paginate (20)->setPath ( '' );
            $pagination = $users->appends ( array (
                        'q' => Input::get ( 'q' ) 
                ));
  
            if (count ( $users ) > 0)
                return view ( 'admin.users',['users' => $users,'totalusers' => $totalusers] )->withQuery ( $q );
            else
            {
              $users = $user->paginate('20');
                return view ('admin.users', [
                        'users' => $users,
                        'totalusers' => $totalusers,
                    ]);
            }

          }

          // elseif ($emailverified == '1' && $kycverified == '1') 
          //   {
          //     //dd('sdf');
          //     $users = $user->whereHas('userprofile', function ($query)  
          //     {
          //       $query->where([['email_verified','=','1'],['kyc_approved','=','1']]);
          //     })->paginate(20)->setPath('');
            
          //   if (count($users)>0)
          //       return view ('admin.users',[
          //         'users' => $users,
          //         'totalusers' => $totalusers
          //         ])->withQuery($emailverified);
          //     else
          //     {
          //     //dd('sdf');
          //       $users = $user->paginate('20');
          //         return view ('admin.users', [
          //           'users' => $users,
          //           'totalusers' => $totalusers,
          //         ]);
          //     }
          //   }

          elseif(isset($verified))
          {
            //dd('sjfuj');
         
            if ($emailverified) 
            {             
              $users = $user->whereHas('userprofile', function ($query)  
              {
                $query->where('email_verified','=','1');
              })->paginate(20)->setPath('');

              if (count($users)>0)
                return view ('admin.users',[
                  'users' => $users,
                  'totalusers' => $totalusers
                  ])->withQuery($emailverified);
              else
              {
              //dd('sdf');
                $users = $user->paginate('20');
                  return view ('admin.users', [
                    'users' => $users,
                    'totalusers' => $totalusers,
                  ]);
              }
            }

            // if ($kycverified) 
            // {     

            //   $users = $user->whereHas('isKycApproved', function ($query)  
            //   {
            //     //dd($query->get());
            //     $query->where([['isKycApproved','=','1'],['email_verified','=','1']]);
            //   })->paginate(20)->setPath('');

            //   // $kyc=$user->get();
            //   // $users = $kyc->filter(function($model)
            //   // {
            //   //  return $model->isKycApprovedCheck == 1;
            //   // });
            //  //$paginator = new \Illuminate\Pagination\Paginator($users, 10);

            //   if (count($users)>0)
            //     return view ('admin.users',[
            //       'users' => $users,
            //       'totalusers' => $totalusers
            //       ])->withQuery($kycverified);
            //   else
            //   {
            //   //dd('sdf');
            //     $users = $user->paginate('20');
            //       return view ('admin.users', [
            //         'users' => $users,
            //         'totalusers' => $totalusers,
            //       ]);
            //   }
            // }
          

            
          }
       // return view ( 'welcome' )->withMessage ( 'No Details found. Try to search again');
          else
          {
              $users = $user->paginate('20');
                return view('admin.users', [
                        'users' => $users,
                        'totalusers' => $totalusers,
                    ]);
          }
    }
    
    public function stafflist()
    {
        $users = User::with(['userprofile', 'agent'])->get();
        $staffs = new Collection;
        foreach ($users as $user) {
            if($user->userprofile->usergroup_id == "2") {
                $staffs->push($user);
            }
        }
       // dd($staffs);
        return view ('admin.staffs', [
                'staffs' => $staffs
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $usergroup = array('2' => 'Staff', '3' => 'Member');
       
       // $account_type=array('business' => 'Business', 'personal' => 'Personal');
         return view('admin.createuser',[
            'usergroup' => $usergroup,
          //  'account_type' => $account_type
            ]);
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
      Validator::extend('checkblockedusername', function ($attribute, $value, $parameters, $validator) {
                 $checkblockedusername = Blockedusername::where('username', Input::get('name'))->exists();  
                
                   if ($checkblockedusername)
                   {
                        return FALSE;
                   }
                   return TRUE;            
        }, trans('forms.checkblockedusername'));

      $sponsor_id = $this->getSponsorId('');

      $validator = Validator::make($request->all(), [
                'usergroup' => 'required',
                'name' => 'required|regex:/^[a-zA-Z0-9]+$/u|min:6|max:12|unique:users|checkblockedusername',
                'email' => 'required|email|max:255|unique:users',           
                'password' => 'required|min:6', 
               // 'account_type'=>'required',
                //'cpassword' => 'required|min:6|same:password'                
            ]);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }   
       
        $defaultReferralGroup = Referralgroup::where('is_default', '1')->first()->id;

        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
          //  'account_type'=>$request->account_type,
            'referralgroup_id' => $defaultReferralGroup,
            'sponsor_id' => $sponsor_id,
        ]);

        $userprofile = $this->admincreateuserprofile($user, $request); 
        if ($request->usergroup == 2)
        {
            return redirect(url('admin/staffs')); 
        }
        else
        {
            return redirect(url('admin/users')); 
        }
        


    }    

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
  public function show($id)
  {
      //dd("NN");
     $user = User::where('id', $id)
      ->with(['userprofile', 'loguser', 'withdraws'])
      ->first();
     // dd($user->CashPointBalance);

      // dd($user);
      // $walletlists = Usercurrencyaccount::where('user_id' , $id)->with('currency')->get();

      $walletlists =  Currency::orderBy('order','ASC')->get();


         // $wallets =new Collection;
         // foreach($walletlists as $wallet){

         //       $userbalance=$this->getcurrencyBalance($wallet->name,$wallet->id,$id,'balance');

         //     //dd($user->userprofile->userprofiletype->name);
         //             $wallets->push([
         //            'name' => $wallet->name,
         //            'token' => $wallet->token,
         //            'image' => $wallet->image,
         //            'displayname' =>$wallet->displayname,
         //            'userbalance' => $userbalance,
         //            'address' =>'',
         //            'pendingbalance' =>0,
                   
         //            ]);
              

         // }

         // foreach($wallets as $wallet){

         //  dd($wallet['displayname']);

         // }
        //dd($wallets);

         
     $loginhistory = ActivityLog::whereIn('log_name', array('login', 'logout'))->where('causer_id', $user->id)->orderBy('id', 'DESC')->get();

     $lastlogin = $loginhistory->where('log_name', 'login')->last();  

     $withdraw =Withdraw::Where('user_id',$user->id)->with('currency','user','userpayaccounts')->get();

     //$withdraw = $user->withdraws;
     $pendingwithdraws  = $withdraw->where('status', 'pending');
     $completedwithdraws  = $withdraw->where('status', 'completed');
     $rejectedwithdraws  = $withdraw->where('status', 'rejected'); 


    $cryptowithdraw = Transfer::Where('user_id',$user->id)->orderBy('id','DESC')->with('currency','user')->get();

    //dd($cryptowithdraw);


    // Fund Transfers
    $currency_id = Currency::get()->pluck('id')->toarray();
    $fundtransfer = Fundtransfer::with('fundtransfer_to_id', 'fundtransfer_from_id', 'transaction')->get();
    $account_id = Usercurrencyaccount::where('user_id', '=', $id)->whereIn('currency_id', $currency_id)->get()->pluck('id')->toArray();
    $sendtransferlists = $fundtransfer->whereIn('from_account_id', $account_id);
    $receivetransferlists = $fundtransfer->whereIn('to_account_id', $account_id);

           // $allPayments = Paymentgateway::where([
           //                                      ['active', '=', "1"],
           //                                      ['withdraw', '=', "1"]
           //                                  ])->get();

           //  $bitcoin_direct   = $allPayments->where('id', '2')->count();
           //  $bankusd  = $allPayments->where('id', '3')->count();
           //  $bankgbp  = $allPayments->where('id', '4')->count();
           //  $bankeuro  = $allPayments->where('id', '5')->count();
           //  $bankngn  = $allPayments->where('id', '6')->count();   

           //  $paymentsResult  = Userpayaccounts::where([                                        
           //                                  ['user_id', '=', $id],                   
           //                                  ['active', '=', "1"]
           //                                  ])->get(); 

           //  $bitcoin_result  = $paymentsResult->where('paymentgateways_id', '2');
           //  $bankwire_usd_result  = $paymentsResult->where('paymentgateways_id', '3');  
           //  // dd($bankwire_result);
           //  $bankwire_gbp_result  = $paymentsResult->where('paymentgateways_id', '4');     
           //  $bankwire_euro_result  = $paymentsResult->where('paymentgateways_id', '5');     
           //  $bankwire_ngn_result  = $paymentsResult->where('paymentgateways_id', '6');       

           // dd($account_id);

    $buyorderlists=TradeOrders::where([['type','buy'],['user_id','=',$id],['status','!=','cancel']])->with('fromcurrency','tocurrency')->orderBy('id','DESC')->get();

      //dd($buyorderlists);


    $sellorderlists=TradeOrders::where([['type','sell'],['user_id','=',$id],['status','!=','cancel']])->with('fromcurrency','tocurrency')->orderBy('id','DESC')->get();

    $completeorderlists=TradeOrders::where([['type','order'],['user_id','=',$id]])->with('fromcurrency','tocurrency','buyorder')->orderBy('id','DESC')->get();

    //dd($completeorderlists);

    $cancelorderlists=TradeOrders::where([['status','cancel'],['user_id','=',$id]])->with('fromcurrency','tocurrency','buyorder')->orderBy('id','DESC')->get();



    $depositfundlists = Transaction::where([
                    ['type', 'credit'],
                    ['action', 'deposit'],
                    ])
                    ->whereIn('account_id', $account_id)
                    ->get();
    $newdepositlist = $depositfundlists->where('deposit_status', 'new');
    //dd($newdepositlist);
    $activedepositlist = $depositfundlists->where('deposit_status', 'active');

    $pg_btc= $this->getPgDetailsByGatewayName('bitcoin_blockio');
    $balance_btc=0;
    $user_accounts_btc=Userpayaccounts::getAccountDetails($id,$pg_btc->id)->first();
    if(count($user_accounts_btc)>0)
    {
      if($user_accounts_btc->btc_address!='')
      {
        $balance_btc=$this->getWalletBalance($user_accounts_btc->btc_address);
      }
    }
      $btc_currency_details=$this->getCurrencyDetailsByName('BTC');

            
      //LTC
    $pg_ltc = $this->getPgDetailsByGatewayName('ltc_blockio');
    $balance_ltc=0;
    $user_accounts_ltc=Userpayaccounts::getAccountDetails($id,$pg_ltc->id)->first();
    if(count($user_accounts_ltc)>0)
    {
        if($user_accounts_ltc->ltc_address!='')
          {
               $balance_ltc=$this->getLTCWalletBalance($user_accounts_ltc->ltc_address);
          }
    }
     $ltc_currency_details=$this->getCurrencyDetailsByName('LTC');


          //DOGE
    /*$pg_doge = $this->getPgDetailsByGatewayName('dogecoin_blockio');
    $balance_doge=0;
    $user_accounts_doge=Userpayaccounts::getAccountDetails($id,$pg_doge->id)->first();
    if(count($user_accounts_doge)>0)
    {
      if($user_accounts_doge->doge_address!='')
        {
             $balance_doge=$this->getDOGEWalletBalance($user_accounts_doge->doge_address);
        }
    }
    $doge_currency_details = $this->getCurrencyDetailsByName('DOGE');*/

    $approveflag=0;
      if(($user->userprofile->passport_verified==0&&is_null($user->userprofile->passport_attachment)&&is_null($user->userprofile->id_card_attachment)&&$user->userprofile->id_card_verified== 0)&&is_null($user->userprofile->driving_license_attachment)&&$user->userprofile->driving_license_verified==0&&is_null($user->userprofile->photo_id_attachment)&&$user->userprofile->photo_id_verified==0&&is_null($user->userprofile->bank_attachment)&&($user->userprofile->kyc_approved==0))
        {
          $approveflag=1;
        }
      //sowmi
      //giftcard
      // $approvelists = GiftcardOrder::where([['user_id', '=', $id],['status', 'approve']])->with('giftcard','user')->paginate(Config::get('settings.pagecount'));
               
      // $completelists = GiftcardOrder::where([['user_id', '=', $id],['status', 'complete']])->with('giftcard','user')->paginate(Config::get('settings.pagecount'));
                
      // $giftwalletlists = GiftcardOrder::where([['user_id', '=', $id],['status', 'wallet']])->with('giftcard','user')->paginate(Config::get('settings.pagecount'));


        $approvelists ='';
               
      $completelists = '';
                
      $giftwalletlists = '';
               
      $fiattransactions = Exchange::where('user_id', '=', $id)->with('exchange_from_account','exchange_to_account')->orderBy('id','DESC')->paginate(10);

      $cryptotransactions = ExternalExchange::where('user_id', '=', $id)->orderBy('id','DESC')->paginate(10);

      $buycoin = Coinorder::where([['from_user_id', '=', $id],['type','buy']])->with('tocurrency','fromcurrency')->orderBy('id','DESC')->paginate(10);

      $user_information= UserInformation::where('user_id', $id)->with('user','empcountry')->first();

      \Session::put('user_id',$id);
      $allpayaccounts = Paymentgateway::where([['active', '=', "1"],['withdraw', '=', "1"]])->with('userpayaccount')->get();

     $sellcoinTransactions = Transfer::where('user_id', '=', $id)->with('currency')->orderBy('id','DESC')->paginate(10);

      $wallets=$this->getCurrencyNew($id);

      //dd(count($wallets));
      $cou=count($wallets)-1;

      $decimal='%0.2f';

           $total_balance=sprintf($decimal,$wallets[$cou]['curbalance']);


      //this.getcurrency[this.array_count].curbalance

      

      return view('admin.userdetail', [
        'user' => $user,
        'sendtransferlists' => $sendtransferlists,
        'receivetransferlists' => $receivetransferlists,
        'loginhistory' => $loginhistory,
        'lastlogin' => $lastlogin,
        'rejectedwithdraws' => $rejectedwithdraws,
        'pendingwithdraws' => $pendingwithdraws,
        'completedwithdraws' => $completedwithdraws,
        'walletlists' => $wallets,
        'newdepositlist' => $newdepositlist,
        'activedepositlist' => $activedepositlist,
        'approveflag'=>$approveflag,
        // 'bitcoin_result' => $bitcoin_result,
        // 'bankwire_usd_result' => $bankwire_usd_result,
        // 'bankwire_ngn_result' => $bankwire_ngn_result,
        // 'bankwire_gbp_result' => $bankwire_gbp_result,
        // 'bankwire_euro_result' => $bankwire_euro_result,
        // 'bitcoin_direct' => $bitcoin_direct,
        // 'bankusd' => $bankusd,
        // 'bankngn' => $bankngn,
        // 'bankgbp' => $bankgbp,
        // 'bankeuro' => $bankeuro,
        'user_accounts_btc'=>$user_accounts_btc,
        'balance_btc'=>$balance_btc,
        'btc_currency_details'=>$btc_currency_details, 
        'balance_ltc'=>$balance_ltc,
        'user_accounts_ltc'=>$user_accounts_ltc,
        'ltc_currency_details'=>$ltc_currency_details,
      //  'user_accounts_doge'=>$user_accounts_doge,
     //   'doge_currency_details'=>$doge_currency_details,
      //  'balance_doge'=>$balance_doge,
        'approvelists' => $approvelists,
        'completelists' => $completelists,
        'giftwalletlists' => $giftwalletlists,
        'fiattransactions' => $fiattransactions,
        'cryptotransactions' => $cryptotransactions,
        'buycoin' => $buycoin,
        'user_information'=>$user_information,
        'allpayaccounts' => $allpayaccounts,
        'sellcoinTransactions'=>$sellcoinTransactions, 
        'buyorderlists'=>$buyorderlists,
        'sellorderlists'=>$sellorderlists,
        'completeorderlists'=>$completeorderlists,
        'cancelorderlists'=>$cancelorderlists,
        'total_assets'=>$total_balance,
        'cryptowithdraw'=>$cryptowithdraw,
        

       

        
      ]);            
    }

  public function verifykyc($id, Request $request)
  {
      // dd($request);
      $userprofile = Userprofile::where('id', '=', $id)->first();
      $userprofile->kyc_verified = 1;
      if( $userprofile->save() )
      {
          $user = User::where('id', $id)->first();
          $user->notify(new KycVerify);
          Mail::to($userprofile->user->email)->queue(new KYCApprove($userprofile));
          $request->session()->flash('successmessage', trans('KYC Document Verified Successfully.')); 
      }
      else
      {
          $request->session()->flash('errormessage', trans('KYC Document Verified Failed!!!. Please Try Again.')); 
      }
      return back();
  }

    public function rejectkyc($id, Request $request)
    {
        $userprofile = Userprofile::where('id', '=', $id)->with('user')->first();


        $userprofile->kyc_verified = 2;
        if( $userprofile->save() )
        {
            $user = User::where('id', $id)->first();
            $user->notify(new KycRejected);
            Mail::to($userprofile->user->email)->queue(new KYCReject($userprofile));
            
            $request->session()->flash('successmessage', trans('KYC Document Rejected Successfully.')); 
        }
        else
        {
            $request->session()->flash('errormessage', trans('KYC Document Rejected Failed!!!. Please Try Again.')); 
        }
        return back();
    }


    public function resetpassword($id, Request $request)
    {
       // dd($id);
        $user = User::where('id', $id)->with('userprofile')->first();
        //dd($user->email);

        $token = str_random(64);

        $password = DB::table(config('auth.passwords.users.table'))->insert([
                'email' => $user->email, 
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]);       

        if($password) 
        {
            Mail::to($user->email)->queue(new ResetPassword($user, $token));
            $request->session()->flash('successmessage', 'Password Reset Successfull for this User.'); 
        } 
        else 
        {
            $request->session()->flash('errormessage', trans('Password Reset Failed!!!. Please Try Again.')); 
        }   

        $this->doActivityLog(
                    $user,
                    $user,
                    ['ip' => request()->ip()],
                    'Reset Password',
                    'Admin Changed Reset Password'
                );

        return back();
    }

    public function resettransactionpassword($id, Request $request)
    {
       // dd($id);
        $userprofile = Userprofile::where('user_id', $id)->with('user')->first();
        $token = str_random(6);
        //dd($token);
        $hashtoken = Hash::make($token);
        //dd($hashtoken); 
        $userprofile->transaction_password = $hashtoken;
        $password = $userprofile->save();

        if($password) 
        {
          Mail::to($userprofile->user->email)->queue(new ResetUserTransactionPassword($userprofile, $token));
          $request->session()->flash('successmessage', 'Reset Transaction Password Successfull for this User.'); 
        } 
        else 
        {
          $request->session()->flash('errormessage', trans('Reset Transaction Password Failed!!!. Please Try Again.')); 
        }     

         $this->doActivityLog(
                    $userprofile->user,
                    $userprofile->user,
                    ['ip' => request()->ip()],
                    'Reset Transaction Password',
                    'Admin Changed Reset Transaction Password'
                );   
        return back();
    }


    public function update($id, Request $request)
    {
       // dd('ffsadfsdfsf');
        $userprofile = Userprofile::where('id', '=', $id)->first();
        $userprofile->active = $request->userstatus;
        if( $userprofile->save() )
        {
          $request->session()->flash('successmessage', trans('User Profile Suspended Successfully.')); 
        }
        else
        {
          $request->session()->flash('errormessage', trans('User Profile Suspended Failed!!!. Please Try Again.')); 
        }
        return back();
    }


    public function searchuser(Request $request) 
    {
        $query = $request->get('query','');
        
        $users=User::where('name','LIKE',''.$query.'%')->get()->take(10);
        
        $data=array();

        foreach ($users as $users) 
        {
          $data[]=array('value'=>$users->name,'id'=>$users->id);
        }
        if(count($data))
        {
          return $data;
        }
        else
        {
          return ['value'=>'No Result Found','id'=>''];
        }
    }

    public function resendverification($id, Request $request)
    {
      
        $user = User::find($id)->first();
        $userprofile = Userprofile::where('user_id',$id)->first();

        Mail::to($user->email)->queue(new EmailVerification($userprofile));      

           
        $request->session()->flash('successmessage', 'Re-Send Mail Send Successfully for this User.'); 
             
         return back();
    }

    public function destroy($id)
    {
      if (!is_null($id))
      {
        $deleteuserprofile = Userprofile::where('user_id', $id)->delete();
        $usercurrencyaccount = Usercurrencyaccount::where('user_id',$id)->pluck('id');
        //dd($usercurrencyaccount);
        if(count($usercurrencyaccount)>0)
        {
          $transaction = Transaction::whereIn('account_id',[$usercurrencyaccount])->delete();
          $gettransactioninFund = Fundtransfer::whereIn('from_account_id', [$usercurrencyaccount])->delete();
        }
        $deleteActivityLog = ActivityLog::where('causer_id', $id)->delete();
        //dd($transaction);
       // $deletePlacement = Placement::where('user_id', $id)->delete();
        $deleteTicket = Ticket::where('user_id', $id)->delete();
        
        $usercurrencyac = Usercurrencyaccount::where('user_id',$id)->delete();

        $user = User::where('id', $id)->delete();
        
        \Session::put('successmessage', trans('forms.user_delete'));    
      }
      return back();
    }

    public function create_msg($user_id)
    {
      return view('admin.sendmsg.msg',[
                'user_id' => $user_id,
            ]);
    }

    public function store_msg(Request $request)
    {
      $conversation = new Conversation;
      $conversation->user_one = Auth::id();
      $conversation->user_two = $request->user_id;

        if ($conversation->save())
        {
            $message = new Message;
            $message->message = $request->message;
            $message->user_id = Auth::id();
            $message->conversation_id = $conversation->id;

            if ($message->save())
            {
                $request->session()->flash('successmessage', trans('forms.message_success'));
            }
            else
            {
                $request->session()->flash('errormessage', trans('forms.message_failure'));
            }
        }
        else
        {
            $request->session()->flash('errormessage', trans('forms.message_failure'));
        }
        $redirectpath = "admin/message/conversation/".$conversation->id;
        return \Redirect::to($redirectpath);
    }

    public function create_mail($user_id)
    {
       \Session::put('sendmail_user_id',$user_id);

        $user = User::where('id', \Session::get('sendmail_user_id'))->first();

        if(count($user))
        {
          return view ('admin.sendmail.create',[
            'user_id'=>$user_id,
            'user'=>$user
          ]);
        }
        else
        {
            abort(403);
        }
      
    }

    public function store_mail()
    {
      $request->merge(['user_id'=>\Session::get('sendmail_user_id')]);   
        $create=[
            'user_id'=>$request->user_id,
            'subject'=>$request->subject,
            'message'=>$request->message,                            
        ];
        $sendmail = SendMail::create($create);   
        $user = User::where('id', $sendmail->user_id)->first();
        Mail::to($user->email)->queue(new SendMailToUser($sendmail));  
        \Session::put('successmessage','Send Mail Successfully ');
        return  Redirect::to('admin/sendmail');
    }

    public function balance($id)
    {
      $walletlists = Usercurrencyaccount::join('currencies', 'usercurrencyaccounts.currency_id', '=', 'currencies.id')
            ->select('usercurrencyaccounts.*', 'currencies.*')
            ->where('usercurrencyaccounts.user_id', $id)
            ->where('currencies.status', 1)            
            ->orderBy('currencies.order', 'ASC')
            ->get(); 
      // dd($walletlists);
      //BTC
        $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');
        $balance=0;
        $user_accounts=Userpayaccounts::getAccountDetails($id,$pg->id)->first();
        if(count($user_accounts)>0)
        {
            if($user_accounts->btc_address!='')
              {
                   $balance = $this->getWalletBalance($user_accounts->btc_address);
              }
        }
     
        //LTC
        $pg_ltc = $this->getPgDetailsByGatewayName('ltc_blockio');
        $balance_ltc=0;
        $user_accounts_ltc=Userpayaccounts::getAccountDetails($id,$pg_ltc->id)->first();
        if(count($user_accounts_ltc)>0)
        {
            if($user_accounts_ltc->ltc_address!='')
              {
                   $balance_ltc = $this->getLTCWalletBalance($user_accounts_ltc->ltc_address);
              }
        }

        //DOGE
        $pg_doge = $this->getPgDetailsByGatewayName('dogecoin_blockio');
        $balance_doge=0;
        $user_accounts_doge=Userpayaccounts::getAccountDetails($id,$pg_doge->id)->first();
        if(count($user_accounts_doge)>0)
        {
            if($user_accounts_doge->doge_address!='')
              {
                   $balance_doge=$this->getDOGEWalletBalance($user_accounts_doge->doge_address);
              }
        }

        $btc = $this->getCurrencyDetailsByName('BTC');
        $ltc = $this->getCurrencyDetailsByName('LTC');
        $doge = $this->getCurrencyDetailsByName('DOGE');
        
        return view('admin.balance.balance_list',[
          'walletlists' => $walletlists,
          'user_accounts'=>$user_accounts,
          'balance'=>$balance,
          'user_accounts_ltc'=>$user_accounts_ltc,
          'balance_ltc'=>$balance_ltc,
          'user_accounts_doge'=>$user_accounts_doge,
          'balance_doge'=>$balance_doge,
          'btc'=>$btc,
          'ltc'=>$ltc,
          'doge'=>$doge,
        ]);
    }

    // public function wallet($id)
    // {
    //   //dd('hdf');
    //   $user = User::where('id', $id)
    //   ->with(['userprofile', 'loguser', 'withdraws'])
    //   ->first();
       
    // $walletlists = Usercurrencyaccount::where('user_id' , $id)->with('currency')->get();
    //         //dd($walletlists);
    // $loginhistory = ActivityLog::whereIn('log_name', array('login', 'logout'))->where('causer_id', $user->id)->orderBy('id', 'DESC')->get();

    // $lastlogin = $loginhistory->where('log_name', 'login')->last();   

    // $withdraw = $user->withdraws;
    // $pendingwithdraws  = $withdraw->where('status', 'pending');
    // $completedwithdraws  = $withdraw->where('status', 'completed');
    // $rejectedwithdraws  = $withdraw->where('status', 'rejected');          
    
    // // Fund Transfers
    // $currency_id = Currency::get()->pluck('id')->toarray();
    // $fundtransfer = Fundtransfer::with('fundtransfer_to_id', 'fundtransfer_from_id', 'transaction')->get();
    // $account_id = Usercurrencyaccount::where('user_id', '=', $id)->whereIn('currency_id', $currency_id)->get()->pluck('id')->toArray();
    // $sendtransferlists = $fundtransfer->whereIn('from_account_id', $account_id);
    // $receivetransferlists = $fundtransfer->whereIn('to_account_id', $account_id);

    //        // $allPayments = Paymentgateway::where([
    //        //                                      ['active', '=', "1"],
    //        //                                      ['withdraw', '=', "1"]
    //        //                                  ])->get();

    //        //  $bitcoin_direct   = $allPayments->where('id', '2')->count();
    //        //  $bankusd  = $allPayments->where('id', '3')->count();
    //        //  $bankgbp  = $allPayments->where('id', '4')->count();
    //        //  $bankeuro  = $allPayments->where('id', '5')->count();
    //        //  $bankngn  = $allPayments->where('id', '6')->count();   

    //        //  $paymentsResult  = Userpayaccounts::where([                                        
    //        //                                  ['user_id', '=', $id],                   
    //        //                                  ['active', '=', "1"]
    //        //                                  ])->get(); 

    //        //  $bitcoin_result  = $paymentsResult->where('paymentgateways_id', '2');
    //        //  $bankwire_usd_result  = $paymentsResult->where('paymentgateways_id', '3');  
    //        //  // dd($bankwire_result);
    //        //  $bankwire_gbp_result  = $paymentsResult->where('paymentgateways_id', '4');     
    //        //  $bankwire_euro_result  = $paymentsResult->where('paymentgateways_id', '5');     
    //        //  $bankwire_ngn_result  = $paymentsResult->where('paymentgateways_id', '6');       

    //        // dd($account_id);

    // $depositfundlists = Transaction::where([
    //                 ['type', 'credit'],
    //                 ['action', 'deposit'],
    //                 ])
    //                 ->whereIn('account_id', $account_id)
    //                 ->get();
    // $newdepositlist = $depositfundlists->where('deposit_status', 'new');
    // $activedepositlist = $depositfundlists->where('deposit_status', 'active');

    // $pg_btc= $this->getPgDetailsByGatewayName('bitcoin_blockio');
    // $balance_btc=0;
    // $user_accounts_btc=Userpayaccounts::getAccountDetails($id,$pg_btc->id)->first();
    // if(count($user_accounts_btc)>0)
    // {
    //   if($user_accounts_btc->btc_address!='')
    //   {
    //     $balance_btc=$this->getWalletBalance($user_accounts_btc->btc_address);
    //   }
    // }
    //   $btc_currency_details=$this->getCurrencyDetailsByName('BTC');

            
    //   //LTC
    // $pg_ltc = $this->getPgDetailsByGatewayName('ltc_blockio');
    // $balance_ltc=0;
    // $user_accounts_ltc=Userpayaccounts::getAccountDetails($id,$pg_ltc->id)->first();
    // if(count($user_accounts_ltc)>0)
    // {
    //     if($user_accounts_ltc->ltc_address!='')
    //       {
    //            $balance_ltc=$this->getLTCWalletBalance($user_accounts_ltc->ltc_address);
    //       }
    // }
    //  $ltc_currency_details=$this->getCurrencyDetailsByName('LTC');


    //       //DOGE
    // $pg_doge = $this->getPgDetailsByGatewayName('dogecoin_blockio');
    // $balance_doge=0;
    // $user_accounts_doge=Userpayaccounts::getAccountDetails($id,$pg_doge->id)->first();
    // if(count($user_accounts_doge)>0)
    // {
    //   if($user_accounts_doge->doge_address!='')
    //     {
    //          $balance_doge=$this->getDOGEWalletBalance($user_accounts_doge->doge_address);
    //     }
    // }
    // $doge_currency_details = $this->getCurrencyDetailsByName('DOGE');

    // $approveflag=0;
    //   if(($user->userprofile->passport_verified==0&&is_null($user->userprofile->passport_attachment)&&is_null($user->userprofile->id_card_attachment)&&$user->userprofile->id_card_verified== 0)&&is_null($user->userprofile->driving_license_attachment)&&$user->userprofile->driving_license_verified==0&&is_null($user->userprofile->photo_id_attachment)&&$user->userprofile->photo_id_verified==0&&is_null($user->userprofile->bank_attachment)&&($user->userprofile->kyc_approved==0))
    //     {
    //       $approveflag=1;
    //     }
    //   //sowmi
    //   //giftcard
    //   $approvelists = GiftcardOrder::where([['user_id', '=', $id],['status', 'approve']])->with('giftcard','user')->paginate(Config::get('settings.pagecount'));
               
    //   $completelists = GiftcardOrder::where([['user_id', '=', $id],['status', 'complete']])->with('giftcard','user')->paginate(Config::get('settings.pagecount'));
                
    //   $giftwalletlists = GiftcardOrder::where([['user_id', '=', $id],['status', 'wallet']])->with('giftcard','user')->paginate(Config::get('settings.pagecount'));
               
    //   $fiattransactions = Exchange::where('user_id', '=', $id)->with('exchange_from_account','exchange_to_account')->orderBy('id','DESC')->paginate(10);

    //   $cryptotransactions = ExternalExchange::where('user_id', '=', $id)->orderBy('id','DESC')->paginate(10);

    //   $buycoin = Coinorder::where([['from_user_id', '=', $id],['type','buy']])->with('tocurrency','fromcurrency')->orderBy('id','DESC')->paginate(10);

    //   $user_information= UserInformation::where('user_id', $id)->with('user','empcountry')->first();

    //   \Session::put('user_id',$id);
    //   $allpayaccounts = Paymentgateway::where([['active', '=', "1"],['withdraw', '=', "1"]])->with('userpayaccount')->get();

    //  $sellcoinTransactions = Transfer::where('user_id', '=', $id)->with('currency')->orderBy('id','DESC')->paginate(10);


    //     return view('admin.userdetail.show',[
    //     'user' => $user,
    //     'sendtransferlists' => $sendtransferlists,
    //     'receivetransferlists' => $receivetransferlists,
    //     'loginhistory' => $loginhistory,
    //     'lastlogin' => $lastlogin,
    //     'rejectedwithdraws' => $rejectedwithdraws,
    //     'pendingwithdraws' => $pendingwithdraws,
    //     'completedwithdraws' => $completedwithdraws,
    //     'walletlists' => $walletlists,
    //     'newdepositlist' => $newdepositlist,
    //     'activedepositlist' => $activedepositlist,
    //     'approveflag'=>$approveflag,
    //     // 'bitcoin_result' => $bitcoin_result,
    //     // 'bankwire_usd_result' => $bankwire_usd_result,
    //     // 'bankwire_ngn_result' => $bankwire_ngn_result,
    //     // 'bankwire_gbp_result' => $bankwire_gbp_result,
    //     // 'bankwire_euro_result' => $bankwire_euro_result,
    //     // 'bitcoin_direct' => $bitcoin_direct,
    //     // 'bankusd' => $bankusd,
    //     // 'bankngn' => $bankngn,
    //     // 'bankgbp' => $bankgbp,
    //     // 'bankeuro' => $bankeuro,
    //     'user_accounts_btc'=>$user_accounts_btc,
    //     'balance_btc'=>$balance_btc,
    //     'btc_currency_details'=>$btc_currency_details, 
    //     'balance_ltc'=>$balance_ltc,
    //     'user_accounts_ltc'=>$user_accounts_ltc,
    //     'ltc_currency_details'=>$ltc_currency_details,
    //     'user_accounts_doge'=>$user_accounts_doge,
    //     'doge_currency_details'=>$doge_currency_details,
    //     'balance_doge'=>$balance_doge,
    //     'approvelists' => $approvelists,
    //     'completelists' => $completelists,
    //     'giftwalletlists' => $giftwalletlists,
    //     'fiattransactions' => $fiattransactions,
    //     'cryptotransactions' => $cryptotransactions,
    //     'buycoin' => $buycoin,
    //     'user_information'=>$user_information,
    //     'allpayaccounts' => $allpayaccounts,
    //     'sellcoinTransactions'=>$sellcoinTransactions, 
    //     ]);
    // }

    public function disableTwoFactor(Request $request,$id)
    {
      $user = User::where('id', $id)->with('userprofile')->first();
      //dd($user);
      //$userreq = $request->user();
        //make secret column blank
        $user->google2fa_secret = null;
        $user->google2fa_secret_status = 0;
        $user->save();

        if($user) 
        {
          $request->session()->flash('successmessage', 'Google 2FA Reset Successfull for this User.'); 
        } 
        else 
        {
          $request->session()->flash('errormessage', trans('Google 2FA Reset Failed!!!. Please Try Again.')); 
        }   

        return back();
    }
    public function getCurrencyNew($id)
    {
        $currency = Currency::orderBy('order', 'ASC')->get();
        $totalequ = 0;
        $i = 0;
        $balance = 0;
        $equ = 0;
        $address ="";

         $wallets =new Collection;
        foreach ($currency as $val) {
            $balance = 0;
            $equ = 0;
            $address ="";  
            $i++;
            try {
                $user = User::where('id', $id)->with('userprofile')->first();
                if ($val->name == "KRW") {
                  $userpay = Usercurrencyaccount::where('currency_id', $val->id)->where('user_id', $id)->first();
                   $address = $userpay->account_no;
                    $balance = $this->getUserCurrencyBalance($user, $val->id);

                    $equ = $balance;

                   // $totalequ += $balance;

                } else if ($val->name == "USD") {

                  $userpay = Usercurrencyaccount::where('currency_id', $val->id)->where('user_id', $id)->first();

                    $address = $userpay->account_no;
                    $balance = $this->getUserCurrencyBalance($user, $val->id);

                    $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                  // $totalequ += $equ;
                } else if ($val->name == 'BTC') {
                    //BTC
                    $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');

                   // dd($pg);

                    $user_accounts = Userpayaccounts::getAccountDetails($id, $pg->id)->first();
                    if (count($user_accounts) > 0) {

                         $address = $user_accounts->btc_address;
                        if ($user_accounts->btc_address != '') {
                            $balance = $this->getWalletBalance($user_accounts->btc_address);

                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');

                           // $totalequ += $equ;

                        }
                    }
                } else if ($val->name == 'LTC') {
                    $pg = $this->getPgDetailsByGatewayName('ltc_blockio');

                    $user_accounts = Userpayaccounts::getAccountDetails($id, $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $address = $user_accounts->ltc_address;
                        if ($user_accounts->ltc_address != '') {
                            $balance = $this->getLTCWalletBalance($user_accounts->ltc_address);
                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                       //  $totalequ += $equ;

                        }
                    }
                } else if ($val->name == 'ETH') {
                    $pg = $this->getPgDetailsByGatewayName('eth');

                    $user_accounts = Userpayaccounts::getAccountDetails($id, $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $address = $user_accounts->eth_address;
                        if ($user_accounts->eth_address != '') {
                            $balance = $this->getETHWalletBalance($user_accounts->eth_address);
                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                        // $totalequ += $equ;

                        }
                    }
                } else if ($val->name == 'BCH') {
                    $pg = $this->getPgDetailsByGatewayName('bch');

                    $user_accounts = Userpayaccounts::getAccountDetails($id, $pg->id)->first();
                    if (count($user_accounts) > 0) {
                        $address = $user_accounts->bch_address;
                        if ($user_accounts->bch_address != '') {
                            $balance = $this->getBCHWalletBalance($user_accounts->bch_address);
                            $equ = $this->getexchangerate($balance, 'KRW', $val->name, 'buy');
                            // $totalequ += $equ;

                        }
                    }
                }

            } catch (Exception $e) {

                // dd($e->getMessage());
            }

             $wallets->push([
                "curname" => $val->name,
                "curname_webtype" => strtolower($val->name),
                "id" => $val->id,
                "displayname" => $val->displayname,
                "currimage" => $val->image,
                "type" => $val->type,
                "count_array" => $i,
                "curbalance" => $totalequ,
                "balance" => $balance,
                "equ" => $equ,
                "address"=>$address   
            ]);

        }


        //$currencylist = json_encode($curr_detail);

        //$array['currencylist']=  $currency;
        //$array['sellorders']= $sellorders;

        //dd($wallets);

        return $wallets;

    }
}

?>