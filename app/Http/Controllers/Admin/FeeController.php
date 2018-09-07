<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Traits\Common;
use Carbon\Carbon;

class FeeController extends Controller
{
    use Common;
    
    public function __construct()
    {
        $this->middleware(['auth','admin1']);
    }

    public function index(Request $request)
    {         
        $q = Input::get('q');
        $from_date = date('Y-m-d H:i:s',strtotime($request->from_date));
        $to_date = date('Y-m-d H:i:s',strtotime($request->to_date));
        
        $accounting_code=$this->getAccountingCode('external-exchange-fee');

        $feetxn = Transaction::where('accounting_code_id' ,$accounting_code)->where('type', 'credit')->with('externalexchange')->orderBy('id','DESC');
        
        if(($request->report !='') && isset($request->reportbutton))
        {
            $accounting_code = $this->getAccountingCode('external-exchange-fee');

            $searchusers = $feetxn->whereRaw('date(created_at) = CURDATE()')->paginate(20); 
           //dd($posts);
        }
        // else 
        // {
        //   // dd('sowmi');
        //     $accounting_code = $this->getAccountingCode('external-exchange-fee');

        //     $posts = Transaction::where('accounting_code_id' ,$accounting_code)->where('type', 'credit')->whereRaw('date(created_at) = CURDATE()')->with('externalexchange')->orderBy('id','DESC')->paginate(20); 

        //     $searchusers = $posts;

        //    return view('admin.externalexchange.showfee',[
        //                      'searchusers' => $searchusers,
        //                      ]);
        // }
 

  
       

       elseif(($q != "") && (isset($request->searchbutton)))
        //elseif ($q!='') 
        {

       
            //do TL Sis
            // $searchusers = $feetxn->where('amount', 'LIKE', '%' . $q . '%' )->orwhereHas('externalexchange["from_currency"]', function ($query) use ($q) {
            //               $query->where('token', 'LIKE', '%' . $q . '%');
            //         })->paginate(20)->setPath ( '' );

            $searchusers = $feetxn->where('amount','LIKE','%'.$q.'%')->paginate(20)->setPath('');
            $pagination = $searchusers->appends(array('q' => Input::get('q')));
            
            // if (count($searchusers)>0)
            //     return view('admin.externalexchange.showfee',['searchusers' => $searchusers] )->withQuery($q);
            // else
            // {
            //     dd('fdjdskf');
            //     $searchusers = $feetxn->paginate('20');
            //         return view('admin.externalexchange.showfee',[
            //                 'searchusers' => $searchusers,
            //     ]);
            // }
        } 

       

        elseif (($from_date != "") && ($to_date != "") && (isset($request->from_date)) && (isset($request->datebutton))) 
        {
         
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
                return back()->withInput()->withErrors($validator);
            }
            
            $searchusers = $feetxn->whereBetween('created_at',[$from_date,$to_date])->paginate(20);
                //if (count($searchusers)>0)
                    // return view('admin.externalexchange.showfee',['searchusers' => $searchusers] )->withQuery($q);  
        }  
        else
        {
            //dd('sdkf');
            $searchusers = $feetxn->paginate('20');
        }
        return view ('admin.externalexchange.showfee',[
                        'searchusers' => $searchusers,
                        
                ]);
    }
}
