<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Coinorder;
use Carbon\Carbon;
use App\MemberGroup;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Withdraw;
use App\Models\Transaction;
use App\Models\Userprofile;
use Illuminate\Http\Request;
use App\Models\Fundtransfer;
use App\MemberGroupUserLink;
use App\Models\Usercurrencyaccount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class MemberGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $membergroup = MemberGroup::paginate(20);
      
        return view('admin.usergroup.show',[
            'membergroup' => $membergroup,
            //'membergroupuser' => $membergroupuser,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $deletegrp = MemberGroup::where('id',37)->first();

        $deletegrplink = MemberGroupUserLink::where('membergroup_id',$deletegrp)->delete();

        $currency = Currency::where('status',1)->get();
        $country = Country::get();
        $buycoin_currency = Currency::where('is_coin',1)->get();

        return view('admin.usergroup.create',[
            'currency' => $currency,
            'country' => $country,
            'buycoin_currency' => $buycoin_currency,
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
        $result = [];
        $country = [];
        $flag_array=[];
        $withdraw = [];
        $rulearray1 = [];
        $rulearray2 = [];
        $rulearray3 = [];
        $rulearray4 = [];
        $rulearray5 = [];
        $rulearray6 = [];
        $rulearray7 = [];
        $rulearray8 = [];
        $final_result = [];
        $user_register = [];
        $userprofile_active = [];

        $downline_abovecount = Input::get('downline_abovecount');
        $downline_fromcount = Input::get('downline_fromcount');
        $downline_tocount = Input::get('downline_tocount');
        $currency = Input::get('currency');
        $buycoin_aboveamt = Input::get('buycoin_amt');
        $buycoin_fromamt = Input::get('from_amt');
        $buycoin_toamt = Input::get('to_amt');
        $status = Input::get('status');
        //$email = Input::get('email_verified');
        //dd($email);
        $verified = Input::get('date_after');
        //dd($verified);
        $amount = Input::get('amt');
        $country_id = Input::get('country');
        $fromdate = date('Y-m-d H:i:s',strtotime(Input::get('from_date')));
        $todate = date('Y-m-d H:i:s',strtotime(Input::get('to_date')));
        $registeron = date('Y-m-d',strtotime(Input::get('date_on')));
       //$kyc = Input::get('kyc_verified');
        
        $flag=0;   
         
        if ($request->ruleone == 1) 
        {

            if ($request->period == 'after') 
            {
                $rulearray1 = User::with('userprofile')->UserGroupforRegisterAfter('3',$verified)->pluck('id')->toArray();
                //dd($rulearray1);
            }
            
            if ($request->period == 'between') 
            {
                $rulearray1 = User::with('userprofile')->UserGroupforRegisterBetween('3',$fromdate,$todate)->pluck('id')->toArray();
                //dd($rulearray1);
            }

            if ($request->period == 'today') 
            {
                //dd($registeron);
                $rulearray1 = User::with('userprofile')->UserGroupforRegisterOn('3',$registeron)->pluck('id')->toArray();
                //dd($rulearray1);
            }
            $flag++;

            if(count($rulearray1)>0)
            {
                 echo "rule1" ."<br>";

                $flag_array[] = 1;

                $final_array[] = $rulearray1;
                //dd($final_array);
            }
        }

        if ($request->kyc_verified == 2) 
        {
            $rulearray2 = User::with('userprofile')->UserGroupforKYCVerifyStatus('3')->pluck('id')->toArray();

            // if ($kyc == 'kyc_yes') 
            // {
            // //dd('dksfjf');
            // $rulearray2 = User::with('userprofile')->UserGroupforKYCVerifyStatus('3')->pluck('id')->toArray();
            // //dd($rulearray2);
            // }   
//dd($rulearray2);
            $flag++;

            if(count($rulearray2)>0)
            {
                echo "rule2" ."<br>";
                $flag_array[] = 2;

                $final_array[] = $rulearray2; 
                //dd($final_array);
            }

        }
//dd($request->rulethree);
        if($request->rulethree == 3)
        {
            //dd('dklfj');
            $rulearray3 = User::with('userprofile')->UserGroupforStatus('3',$status)->pluck('id')->toArray();
//dd($rulearray3);
            $flag++;

            if(count($rulearray3)>0)
            {
                echo "rule3" ."<br>";
                $flag_array[] = 3;

                $final_array[] = $rulearray3; 
                //dd($final_array);
            }
        }

        if($request->rulefour == 4)
        {
            $currency_account = Usercurrencyaccount::with('userprofile')->UserGroup(3)->where('currency_id',$currency)->pluck('id')->toArray();

            if ($request->condition == 'transaction') 
            {
               $condition_result = Transaction::selectRaw("account_id,SUM(case when type='credit' and action In('deposit', 'transfer', 'exchange','buygiftcardwallet','buycoin','withdraw') and status=1 then amount else 0 end) - SUM(case when type='debit' then amount else 0 end)  as balance")->groupBy('account_id')->pluck('balance','account_id');     
            }    
            else
            {
                //dd($request->condition);
                if ($request->condition == 'withdraw') 
                {
                    $action = 'withdraw';
                    $status = 1;
                }

                if ($request->condition == 'fund_transfer') 
                {
                    $action = 'transfer';
                    $status = 0;
                }

                    if (count($currency_account)>0) 
                    {
                        $condition_result = Transaction::selectRaw('account_id,sum(amount) as amount')->whereIn('account_id',$currency_account)->where([['action',$action],['status',$status]])->groupBy('account_id')->pluck('amount','account_id');
                        //dd($condition_result);
                    }
            }
            
            if ($request->amt_level == 1) 
            {//dd('sdkjf');
                $filtered = $condition_result->filter(function ($value, $key) use ($amount)
                {
                    //echo $value ."<br>".$amount;
                    return $value > $amount;
                });
                //dd($filtered);
               
            }

            else if ($request->amt_level == 2) 
            {
                $filtered = $condition_result->filter(function ($value, $key) use ($amount)
                {
                   // echo $amount . "<br>"."$value";
                    return $value < $amount;
                }); 
            }

            else if ($request->amt_level == 3) 
            { 
                $filtered = $condition_result->filter(function ($value, $key) use ($amount)
                {
                    //echo $amount . "<br>"."$value";
                    return $value == $amount;
                });
            }

            $all = $filtered->all();
//dd($all);
            $final_result = array_keys($all);
//dd($final_result);
            if(count($final_result)>0)
            {
                $rulearray4 = Usercurrencyaccount::whereIn('id',$final_result)->pluck('user_id')->toArray();
            }

            $flag++;

            if(count($rulearray4)>0)
            {
                echo "rule4" ."<br>";
                $flag_array[] = 4;

                $final_array[] = $rulearray4;
                //dd($final_array);
            }
        }

        if($request->rulefive == 5)
        {
            $rulearray5 = User::with('userprofile')->UserGroupforCountry('3',$country_id)->pluck('id')->toArray();
            //dd($rulearray5);

            $flag++;

            if(count($rulearray5)>0)
            {
                echo "rule5" ."<br>";
                $flag_array[] = 5;

                $country[] = 0;

                $final_array[] = $rulearray5;
               //dd($final_array);
            }
        }
//dd($request->email);
        if($request->email_verified == 6)
        {
            
            $rulearray6 = User::with('userprofile')->UserGroupforEmail('3')->pluck('id')->toArray();
           // dd($rulearray6);

            $flag++;

            if(count($rulearray6)>0)
            {//dd('dkfj');
        echo "rule6" ."<br>";
                $flag_array[] = 6;

                $final_array[] = $rulearray6;
               // dd($final_array);
            }
        }

        if($request->buy_coin == 7)
        {
            $rulearray7 = Coinorder::selectRaw('from_user_id,sum(amount) as amount')->where([['type','order'],['request_coin_id',$request->buycoin_currency]])->groupBy('from_user_id')->pluck('amount','from_user_id');

            if ($request->buycoin_level == 'above') 
            {
                $buycoin = $rulearray7->filter(function ($value) use ($buycoin_aboveamt)
                {
                    return $value > $buycoin_aboveamt;
                });
            }

            if ($request->buycoin_level == 'between') 
            {
                $buycoin = $rulearray7->filter(function ($value) use ($buycoin_fromamt,$buycoin_toamt)
                {
                    return (($value > $buycoin_fromamt) && ($value < $buycoin_toamt));
                });
            }
            
            $rulearray7 = $buycoin->all();

            $final_result = array_keys($rulearray7);

            $flag++;

            if(count($final_result)>0)
            {
                echo "rule7" ."<br>";
                $flag_array[] = 7;

                $final_array[] = $final_result;
            }
        }

        if($request->downline == 8)
        {
            $collection = User::ByUserType('3')->get();

            $downline_level = $request->downline_count;
            //dd($downline_level);
            $filtered = $collection->filter(function($model) use ($downline_abovecount,$downline_level,$downline_fromcount,$downline_tocount)
            {
                if ($downline_level == 'above') 
                {
                    //dd('fkh');
                    if($downline_abovecount < $model->SponsorCount)
                    return true;
                }
                
                if ($downline_level == 'between') 
                {
                   // echo "downline_fromcount" ."<br>"."downline_tocount" ."<br>"."$model->SponsorCount";
                    if($downline_fromcount < $model->SponsorCount && $downline_tocount > $model->SponsorCount)
                    return true;
                }

            });

                $rulearray8 = $filtered->pluck('user_id')->toArray();
                //dd($final);

            $flag++;

            if(count($rulearray8)>0)
            {
                echo "rule8" ."<br>";
                $flag_array[] = 8;

                $country[] = 0;

                $final_array[] = $rulearray8;
               // dd($final_array);
            }
        }

//dd($final_array);

        $result = [];

        if($flag==count($flag_array))
        {
            for($j=0;$j<count($flag_array);$j++)
            {
                if($j==0)
                {
                    $result = $final_array[$j];
                }
                if($j<(count($flag_array)-1))
                {
                    // echo '<pre>';
                    // print_R($result);echo 'hi';
                    // print_r($final_array[$j+1]);
                   $result = array_intersect($result,$final_array[$j+1]);
                }
           }
        }
    //dd($result);
        $register = [
            "period" => $request->period,
            "after_date" => $request->date_after,
            "from_date" => $request->from_date,
            "to_date" => $request->to_date,
            "register_date" => $request->date_on,
        ];
     
        $country = [
            "country_val" => $request->rulefive,
            "country" => $request->country,
        ];

        $email = [
            "email" => $request->email_verified,
        ];

        $kyc = [
            "kyc_verified" => $request->kyc_verified,
        ];

        $downline = [
            "downline_level" => $request->downline_count,
            "downline_abovecount" => $request->downline_abovecount,
            "downline_fromcount" => $request->downline_fromcount,
            "downline_tocount" => $request->downline_tocount,
        ];

        $wallet = [
            "amt" => $request->amt,
            "amt_level" => $request->amt_level,
            "condition" => $request->condition,
            "currency" => $request->currency,
        ];

        $buycoin = [
            "currency" => $request->buycoin_currency,
            "level" => $request->buycoin_level,
            "buycoin_amt" => $request->buycoin_amt,
            "from_amt" => $request->from_amt,
            "to_amt" => $request->to_amt,
        ];

        $userstatus = [
            "status" => $request->status,
        ];

        $rules['register_rule'] = $register;
        $rules['country_rule'] = $country;
        $rules['email_verified_rule'] = $email;
        $rules['kyc_rule'] = $kyc;
        $rules['downline'] = $downline;
        $rules['wallet_rule'] = $wallet;
        $rules['buycoin'] = $buycoin;
        $rules['status_rule'] = $userstatus;
        
        $storerules = json_encode($rules);
        $membergroupcreate = [
            "usergroup_name" => $request->usergroup_name,
            "rules" => $storerules,
        ];

        $membergroup = MemberGroup::create($membergroupcreate);
 //dd($membergroup);
        foreach ($result as $key => $user_id) 
        {
            $membergrouplink = [
                'membergroup_id' => $membergroup->id,
                'user_id' => $user_id,
            ];

            $membergroup_link = MemberGroupUserLink::create($membergrouplink);
            //dd($membergroup_link);

        }

        return back();
    }

    function filterArray($value)
    {
        return ($value == 2);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $memberedit = MemberGroup::where('id',$id)->first();
        //dd($memberedit);
        $edit = json_decode($memberedit->rules,true);
//dd($edit);
        $currency = Currency::where('status',1)->get();
        return view('admin.usergroup.edit',[
            'memberedit' => $memberedit,
            'edit' => $edit,
            'currency' => $currency,
            ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $memberupdate = MemberGroup::find($id);

        $memberupdate->usergroup_name = $request->usergroup_name;

        $register = [
            "period" => $request->period,
            "after_date" => $request->date_after,
            "from_date" => $request->from_date,
            "to_date" => $request->to_date,
            "register_date" => $request->date_on,
        ];
     
        $country = [
            "country_val" => $request->rulefive,
            "country" => $request->country,
        ];

        $email = [
            "email" => $request->email_verified,
        ];

        $kyc = [
            "kyc_verified" => $request->kyc_verified,
        ];

        $downline = [
            "downline_level" => $request->downline_count,
            "downline_abovecount" => $request->downline_abovecount,
            "downline_fromcount" => $request->downline_fromcount,
            "downline_tocount" => $request->downline_tocount,
        ];

        $wallet = [
            "amt" => $request->amt,
            "amt_level" => $request->amt_level,
            "condition" => $request->condition,
            "currency" => $request->currency,
        ];

        $buycoin = [
            "currency" => $request->buycoin_currency,
            "level" => $request->buycoin_level,
            "buycoin_amt" => $request->buycoin_amt,
            "from_amt" => $request->from_amt,
            "to_amt" => $request->to_amt,
        ];

        $userstatus = [
            "status" => $request->status,
        ];

        // $register = [
        //     "period" => $request->period,
        //     "date" => $request->date,
        //     "from_date" => $request->from_date,
        //     "to_date" => $request->to_date,
        // ];

        // $kyc = [
        //     "kyc_verified" => $request->kyc_verified,
        // ];

        // $userstatus = [
        //     "status" => $request->status,
        // ];

        // $wallet = [
        //     "amt" => $request->amt,
        //     "amt_level" => $request->amt_level,
        //     "currency" => $request->currency,
        // ];

        $rules = array($register,$country,$email,$kyc,$downline,$wallet,$buycoin,$userstatus);

        $storerules = json_encode($rules);
        $create = [
            "usergroup_name" => $request->usergroup_name,
            "rules" => $storerules,
        ];

        $membergroup = MemberGroup::where('id',$id)->update($create);

        return redirect(url('/admin/usergroup/list'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd('dfhf');
       
//dd($deletegrp);
        $deletegrplink = MemberGroupUserLink::where('membergroup_id',$id)->delete();

         $deletegrp = MemberGroup::where('id',$id)->delete();

             
        \Session::put('successmessage','Deleted Successfully');
        
           
        return back();
    }

    public function all_users($id)
    {
        $allusers = MemberGroup::where('id',$id)->with('membergrouplink')->first();

        return view('admin.usergroup.allusers_show',[
                'allusers' => $allusers,
            ]);
    }

    public function show_rules($id)
    {
        $member_rule = MemberGroup::where('id',$id)->first();
//dd($member_rule);
        $rules = json_decode($member_rule->rules,true);
       // $rules=collect($rules);
        //dd($rules);
        return view('admin.usergroup.user_rules',[
            'rules' => $rules,
            'member_rule' => $member_rule,
            ]);        
    }
}
