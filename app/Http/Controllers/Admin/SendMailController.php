<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Validator;
use Carbon\Carbon;
use App\SendMail;
use App\Models\Userprofile;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\SendMailRequest;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailToUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class SendMailController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin1']);
    }

    public function index(Request $request)
    {   

        $from_date = date('Y-m-d H:i:s',strtotime($request->from_date));
        $to_date = date('Y-m-d H:i:s',strtotime($request->to_date));

        $list = SendMail::orderby('id','DESC');


        if ($from_date != "" && $to_date != "" && isset($request->from_date)) 
        {
         //dd('skdfjk');
            Validator::extend('checkdate', function ($attribute, $value, $parameters, $validator) 
            {   
                //dd('sowm');
                $from_date = date('Y-m-d H:i:s',strtotime(Input::get('from_date')));
                $to_date = date('Y-m-d H:i:s',strtotime(Input::get('to_date')));
             // dd($to_date);
                if($from_date <= $to_date)
                {
                    //dd('kdhs');
                    return TRUE;
                }
                    return FALSE;

            }, trans('forms.invalid_date'));

            $validator = Validator::make($request->all(),[
                'from_date' => 'required|checkdate',
                'to_date' => 'required',
                ]);

            if($validator->fails())
            {
                return redirect(url('/admin/sendmail/'))->withInput()->withErrors($validator);
            }
            
            $list = $list->whereBetween('created_at',[$from_date,$to_date])->paginate(20);
        }  
        else
        {
            $list = $list->paginate(20);
        }

        return view ('admin.sendmail.show', [
                'list' => $list,                              
            ]);
    }
    public function create($user_id)
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

    public function store(SendMailRequest $request)
    {
        $request->merge(['user_id'=>\Session::get('sendmail_user_id')]);   
        $create=[
            'user_id'=>$request->user_id,
            'subject'=>$request->subject,
            'message'=>$request->message,                            
        ];
        $sendmail=SendMail::create($create);   
        $user = User::where('id', $sendmail->user_id)->first();
        Mail::to($user->email)->queue(new SendMailToUser($sendmail));  
        \Session::put('successmessage','Send Mail Successfully ');
        return  Redirect::to('admin/sendmail');
    }

    public function viewmessage($id)
    {
        $sendmail=SendMail::find($id);
        return view ('admin.sendmail.viewmessage',[
            'sendmail'=>$sendmail,
        ]);
    }

    public function create_massmail()
    {
        $users = array('active' => 'Active Users', 'suspend' => 'Suspend Users', 'all' => 'All Users');
        return view('massmail.create',[
            'users' => $users,
            ]);
    }

    public function store_massmail(Request $request)
    {
        if($request->to == 'active')
        {
            $massmail = Userprofile::where([['active','1'],['usergroup_id','3']])->with('user')->get();
        }

        if($request->to == 'suspend')
        {
            $massmail = Userprofile::where([['active','0'],['usergroup_id','3']])->with('user')->get();
        }

        if($request->to == 'all')
        {
            $massmail = Userprofile::where('usergroup_id','3')->get();
        }
        
        if(count($massmail)>0)
        {
            foreach ($massmail as $key => $value) 
            {
                $create = [
                    'user_id'=>$value->user->id,
                    'subject'=>$request->subject,
                    'message'=>$request->message,   
                ];
                $massmail = SendMail::create($create); 
                
                Mail::to($value->user->email)->queue(new SendMailToUser($massmail));
            } 
            \Session::put('successmessage','Send Mail Successfully'); 
        }
        return back();
    }
    
}

?>