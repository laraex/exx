<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Userprofile;
use Auth;

class UserController extends Controller
{

    public $successStatus = 200;

    public $failStatus = 302;


    /**

     * login api

     *

     * @return \Illuminate\Http\Response

     */

    public function login(){

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            //dd($user->id);

            $userprofile = Userprofile::where('user_id', $user->id)->first();
            if ($userprofile->active == 1)
            {
                 $token =  $user->createToken('MyApp')->accessToken;

                return response()->json([
                                'status' => 'success',
                                'token' => $token,
                                'user_id' => $user->id
                            ], $this->successStatus);
            }
            elseif ($userprofile->active == 0)
            {
                return response()->json([
                                'status'=>'User Account Suspended. Please Contact Admin.',
                                'token' => ''
                            ], $this->failStatus);
            }
        }
        else{
                return response()->json([
                                'status'=>'Invalid User',
                                'token' => ''
                            ], $this->failStatus);

        }
    }


    /**

     * Register api

     *

     * @return \Illuminate\Http\Response

     */

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                                //'status'=> $validator->errors(),
                                'status'=> 'error',
                                'token' => '',
                                'name' => ''
                            ], $this->failStatus);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        if ($user)
        {
            $userprofile = $this->createuserprofile($user); 
 
           //  $admin = User::find(1);
           //  \Mail::to($user->email)->queue(new RegisterNewUser($user));
           //  \Mail::to($admin->email)->queue(new AdminNotifyNewUser($user));
           //  \Mail::to($user->email)->queue(new EmailVerification($userprofile));

            
           // $this->doActivityLog(
           //      $user,
           //      $user,
           //      ['ip' => request()->ip()],
           //      'register',
           //      'User Registered'
           //  );

        }

        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        $success['status'] =  'success';
        $success['user_id'] =  $user->id;
        return response()->json($success, $this->successStatus);
    }


     public function forgotPassword(){
        //dd(request('email'));

         $user = User::where('email', request('email'))->get(['id'])->toArray();
         //dd($user[0]['id']);

        if(!empty($user)){
            //dd('test');           

            $userprofile = Userprofile::where('user_id', $user[0]['id'])->first();
            //dd($userprofile);
            $userprofile->forgot_password_otp = rand(1000, 10000);
            if ($userprofile->save())
            {
                //dd('111');
                Mail::to(request('email'))->send(new ForgotPasswordOtp($userprofile));
                return response()->json([
                                'status' => 'success',
                                'otpCode' => $userprofile->forgot_password_otp,
                                'otpLink' => url('api/forgot-password/'),
                                'message' => 'Otp sent your registered email id'
                            ], $this->successStatus);
            }
            else
            {
                return response()->json([
                                'status' => 'Fail',
                                'message' => 'Otp sent Failed !!!.'
                            ], $this->failStatus);
            }
            // elseif ($userprofile->active == 0)
            // {
            //     return response()->json([
            //                     'status'=>'User Account Suspended. Please Contact Admin.',
            //                     'token' => ''
            //                 ], $this->failStatus);
            // }
        }
        else{
                return response()->json([
                                'status'=>'Fail',
                                'message'=>'Invalid Email Id',
                            ], $this->failStatus);

        }
    }

    public function forgotPasswordOtpCheck($otp){

        $userprofile = Userprofile::where('forgot_password_otp', $otp)->first();



        if (!empty($userprofile))
        {
            if (request('otp') != $userprofile->forgot_password_otp)
            {
                return response()->json([
                                    'status'=>'Fail',
                                    'message'=>'Otp is mismatch !!!',
                                ], $this->failStatus);
            }

            $user = User::where('id', $userprofile->user_id)->first();
            //dd($user);
            $user->password = bcrypt(request('newpassword'));
            if ($user->save())
            {
                $userprofile->forgot_password_otp = '';
                $userprofile->save();
                return response()->json([
                                'status' => 'success',                             
                                'message' => 'Password changed successfully'
                            ], $this->successStatus);

            }
            else
            {
                return response()->json([
                                'status'=>'Fail',
                                'message'=>'Something went wrong...Please try again',
                            ], $this->failStatus);

            }
            
        }
        else
        {
            return response()->json([
                                'status'=>'Fail',
                                'message'=>'Otp is Invalid !!!',
                            ], $this->failStatus);
        }

    }


    /**

     * details api

     *

     * @return \Illuminate\Http\Response

     */

    public function makeWithdrawOrder()
    {
        //dd(request('account_no'));
        $checkUserAccount  = Usercurrencyaccount::where([                                        
                                            ['account_no', '=', request('account_no')],                   
                                            ['currency_id', '=', "8"]
                                            ])->get(['user_id'])->toArray(); 
        //dd($checkUserAccount);

        if (empty($checkUserAccount))
        {
            return response()->json([
                                'status'=>'userfail',
                                'message'=>'Invalid User',
                            ], $this->failStatus);
        }
        else
        {
            if($checkUserAccount[0]['user_id'] != '')
            {
               // $user = Auth::user();
                //dd($user->id);

                $userprofile = Userprofile::where('user_id', $checkUserAccount[0]['user_id'])->first();   

                $account = Usercurrencyaccount::where([
                    ['user_id', '=', $checkUserAccount[0]['user_id']],
                    ['currency_id', '=', 8]
                ])->get(['id'])->toArray();

            $usercurrencyaccount = $account[0]['id'];

            $accounting_code = Accountingcode::where([
                    ['active', '=', "1"],
                    ['accounting_code', '=', 'deposit-via-banktransfer']
                ])->get(['id'])->toArray();
                $accounting_code = $accounting_code[0]['id'];

                // dd($accounting_code);

                 $request_json = array('payment_id' => 6);
               
                $response_json = array('transaction_number' => uniqid());
               

                $transaction = new Transaction;
                $transaction->account_id = $usercurrencyaccount;
                $transaction->amount = request('amount');
                $transaction->type = "credit";
                $transaction->deposit_status ="active";
                $transaction->status = 1;
                $transaction->action ="deposit";           
                $transaction->accounting_code_id = $accounting_code;
                $transaction->request = json_encode($request_json);
                $transaction->response = json_encode($response_json);

                if ($transaction->save())
                {
                    return response()->json([
                                    'status' => 'success',
                                    'message' => 'Transaction Successfully',
                                    'user_id' => $checkUserAccount[0]['user_id']
                                ], $this->successStatus);
                }  
                else{
                    return response()->json([
                                    'status'=>'fail',
                                    'message'=>'Transaction Failed!!!',
                                ], $this->failStatus);

                }

                    
                
            }
        }       
        
    }
    
}