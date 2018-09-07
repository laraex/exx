<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\CoinProcess;
use App\Models\Transaction;
use App\Models\Userprofile;
use App\Models\Withdraw;
use App\Models\Fundtransfer;
use App\Traits\TicketProcess;
use Carbon\Carbon;
use App\Traits\WithdrawProcess;
//use App\GiftcardOrder;
use App\Models\Conversation;
use App\Session;
use App\User;
use App\Models\Currency;
use App\Models\Usercurrencyaccount;
use App\Models\ActivityLog;
use Illuminate\Support\Collection;
use App\TradeOrders;
use App\Deposit;
class DashboardController extends Controller
{
  use CoinProcess, TicketProcess, WithdrawProcess;

  public function __construct()
  {
       $this->middleware(['auth','admin1']);
  }

  public function index()
  { 
        //dd('sowmi');
    $list = '';

    
    $recent_activity = TradeOrders::orderBy('id','DESC')->with('fromcurrency','tocurrency','user')->paginate(100);
   
   /* $pendingdepositfunds = Transaction::new()->where('action','deposit')->with('user','usercurrencyaccount')->latest()->take(10)->get();*/
       $pendingdepositfunds = Deposit::where('status','new')->get();
    //dd($pendingdepositfunds);
    $withdrawlists = Withdraw::where('status', 'pending')->with(['user', 'transaction', 'userpayaccounts'])->orderBy('id', 'DESC')->take(10)->get();
    //dd($withdrawlists);
    $transferfunds = Fundtransfer::with('fundtransfer_to_id', 'fundtransfer_from_id', 'transaction','currency')->orderBy('id', 'DESC')->take(10)->get();
    //dd($transferfunds);
    $userprofile = Userprofile::where('user_id', Auth::id())->with('user')->first();  
    
    $ticketlist = $this->pendingticketlist($userprofile); 
        
    //$pendingkyclists = Userprofile::whereNotIn('usergroup_id', array('1', '2'))->where('kyc_verified', '=', 0)->where('kyc_doc', '!=', '')->with('user')->orderBy('created_at', 'DESC')->take(10)->get();

    $pending_kyc = Userprofile::whereNotIn('usergroup_id', array('1', '2'))
        ->where( function ( $query )
            {
                $query->where( 'passport_verified', '!=', '1' )
                      ->whereNotNull( 'passport_attachment' );
            })
        ->orwhere( function ( $query )
            {
                $query->where( 'id_card_verified', '!=', '1' )
                      ->whereNotNull( 'id_card_attachment' );
            })
         ->orwhere( function ( $query )
            {
                $query->where( 'driving_license_verified', '!=', '1' )
                      ->whereNotNull( 'driving_license_attachment' );
            })
          ->orwhere( function ( $query )
            {
                $query->where( 'photo_id_verified', '!=', '1' )
                      ->whereNotNull( 'photo_id_attachment' );
            })
           ->orwhere( function ( $query )
            {
                $query->where( 'bank_verified', '!=', '1' )
                      ->whereNotNull( 'bank_attachment' );
            })
        ->with('user')->orderby('id','DESC');

        $pending_kyc_count=$pending_kyc->count();
        $pendingkyclists=$pending_kyc->take(5)->get();

    
    $signedupuserslists = Userprofile::with('user')->orderby('created_at', 'desc')->orderby('id', 'desc')->take(10)->get();
    // dd($signedupuserslists);
    // $giftCardOrders = GiftcardOrder::where('status', 'approve')->with('giftcard', 'user')->orderBy('created_at', 'desc')->take(10)->get();
    
    $userlist = Userprofile::where([
            ['active', 1],
            ['usergroup_id', 3]
        ])->with('user')->get();
    $conversations = Conversation::with(['userone', 'usertwo','message'])->latest()->first();


    $registereduser = Userprofile::where('usergroup_id','3')->where('created_at','>=',Carbon::now()->subDays(10))->selectRaw('Date(created_at) as date ,count(id) as count')->groupBy('date')->pluck('count','date');

    
//sowmi chart
//not done (hours)
    $loggedinlist = Session::whereNotNull('user_id')->where('user_id','!=',Auth::id())->where('last_activity','>=',Carbon::now()->subHour(1))->selectRaw("FROM_UNIXTIME(last_activity,'%Y-%m-%d %H:%i:%s') as date, count(id) as count")->orderBy('id', 'DESC')->pluck('count','date');

//dd($loggedinlist);

// $current_time = Carbon::now();
// $sub10h = $current_time->subHours(10); // This doesn't

// $transactionsFrom = Session::where('user_id','!=',Auth::id())->where('last_activity', '>=', $sub10h->toDateTimeString())->pluck('last_activity');
// dd($transactionsFrom);

        //$currency = Currency::where('status',1)->pluck('id')->toarray();
        //dd($currency);
    $currency = Currency::where('status',1)->get();
    //dd($currency->id);
    $currency_id = $this->getCurrencyId('USD');
// dd($currency_id);
        // foreach ($currency as $currencies) 
        // {
        //    $allAccount = Usercurrencyaccount::where('currency_id',$currencies)->where('user_id', '1')->pluck('id')->toarray();

        //    $getcommissions = Transaction::whereIn('account_id' ,$allAccount)->where('type', 'credit')->where('created_at','>=',Carbon::now()->subDays(7))->selectRaw('Date(created_at) as date ,sum(amount) as amount')->with('accountingcode')->groupBy('date')->pluck('amount','date'); 
           
        // }

   $allAccount = Usercurrencyaccount::where('currency_id',$currency_id)->where('user_id', '1')->pluck('id')->toarray();
// dd($allAccount);
   $getcommissions = Transaction::whereIn('account_id' ,$allAccount)->where('type', 'credit')->where('created_at','>=',Carbon::now()->subDays(7))->selectRaw('Date(created_at) as date ,sum(amount) as amount')->with('accountingcode')->groupBy('date')->pluck('amount','date'); 

           //dd($getcommissions);
    $commissions = $getcommissions->toArray();
//dd($commissions);
    $m = date("m");
    $de = date("d");
    $y = date("Y");
   
    $end_date = date('Y-m-d', mktime(0,0,0,$m,($de - 7), $y));
    //dd($end_date);
    $end = date("d", strtotime($end_date));
//dd($end);
    for($i=0; $i<=7; $i++)
    {
        $date_array[] = date('Y-m-d', mktime(0,0,0,$m,($end + $i), $y));
    }

    $new_array = array();
    $commissions_new_array = array();

      foreach($date_array as $key => $value)
      {
          $commissions_date_exists = array_key_exists($value, $commissions);
         
             if(!$commissions_date_exists)
             {
                 $new_array[$value] = 0;
             }
             else
             {
                 $new_array[$value] = $commissions[$value];
             }
      }

     $getcommissions = collect($new_array);  
     $date_array = collect($date_array); 
               //dd($date_array);
      //dd($getcommissions);
       // dd($getcommissions[1]->values());

        //$allAccounts = Usercurrencyaccount::whereIn('currency_id',[5])->where('user_id','1')->pluck('id')->toarray();

        //$allAccountss = Usercurrencyaccount::whereIn('currency_id',[6])->where('user_id','1')->pluck('id')->toarray();

        //$allAccountsss = Usercurrencyaccount::whereIn('currency_id',[7])->where('user_id','1')->pluck('id')->toarray();

        //dd($allAccounts);

        //$getcommissions = Transaction::whereIn('account_id' ,$allAccount)->where('type', 'credit')->where('created_at','>=',Carbon::now()->subDays(7))->selectRaw('Date(created_at) as date ,sum(amount) as amount')->with('accountingcode')->groupBy('date')->pluck('amount','date'); 
//dd($getcommissions);

        // $walletlists = Usercurrencyaccount::join('currencies', 'usercurrencyaccounts.currency_id', '=', 'currencies.id')
        //     ->select('usercurrencyaccounts.*', 'currencies.*')
        //     ->where('usercurrencyaccounts.user_id', Auth::id())
        //     ->orderBy('currencies.order', 'ASC')
        //     ->get(); 

//member balance
    foreach($currency as $currencies) 
    {
      $allAccount = Usercurrencyaccount::where('currency_id',$currencies->id)->
      whereNotIn('user_id',[ADMIN_ID,BANK_PrimaryCoin])->pluck('id')->toarray(); 
      
      $credittransaction = Transaction::whereIn('account_id' ,$allAccount)->where('type','credit')->sum('amount');
     
      $debittransaction = Transaction::whereIn('account_id' ,$allAccount)->where('type','debit')->sum('amount');
     
      $transactionamt = $credittransaction - $debittransaction;
      
      $totalamt[$currencies->token] = $transactionamt;      
    }

    $totalAmount = collect($totalamt);
 //dd($totalAmount);
//dd($totalAmount->keys());

   return view ('admin.dashboard', [
          'pendingdepositfunds' => $pendingdepositfunds,
          'userlists' => $userlist,
          'withdrawlists' => $withdrawlists,
          'transferfunds' => $transferfunds,
          'ticketlist' => $ticketlist,
          //'pendingkyclists' => $pendingkyclists,
          'signedupuserslists' =>$signedupuserslists,
         // 'giftCardOrders' => $giftCardOrders,
          'conversations' => $conversations,
          'registereduser' => $registereduser,
          'loggedinlist' => $loggedinlist,
          'getcommissions' => $getcommissions,
          'currency' => $currency,
          'currency_id' => $currency_id,
          'date_array'=>$date_array,
          'totalamt' => $totalAmount,
          'pendingkyclists'=>$pendingkyclists,
          'pending_kyc_count'=>$pending_kyc_count,
          'recent_activity'=>$recent_activity
      ]);
    }

    public function getCurrency($id)
    {
      $allAccount = Usercurrencyaccount::where('currency_id',$id)->where('user_id', '1')->pluck('id')->toarray();

      $getcommissions = Transaction::whereIn('account_id' ,$allAccount)->where('type', 'credit')->where('created_at','>=',Carbon::now()->subDays(7))->selectRaw('Date(created_at) as date ,sum(amount) as amount')->with('accountingcode')->groupBy('date')->pluck('amount','date'); 

      $commissions = $getcommissions->toArray();
//dd($commissions);
      $m = date("m");
      $de = date("d");
      $y = date("Y");
     
      $end_date = date('Y-m-d', mktime(0,0,0,$m,($de - 7), $y));
      $end = date("d", strtotime($end_date));

      for($i=0; $i<=7; $i++)
      {
          $date_array[] = date('Y-m-d', mktime(0,0,0,$m,($end + $i), $y));
      }

      $new_array = array();
      $commissions_new_array = array();

      foreach($date_array as $key => $value)
      {
          $commissions_date_exists = array_key_exists($value, $commissions);
         
             if(!$commissions_date_exists)
             {
                 $new_array[] = 0;
             }
             else
             {
                 $new_array[] = $commissions[$value];
             }
      }
         $getcommissions = collect($new_array);

     return $getcommissions;

    }

    public function getCurrencyToken($currency_id)
    {
        $currencydetails = $this->getCurrencyDetails($currency_id);
        //dd($currencydetails);
        return $currencydetails->token;
    }
}


