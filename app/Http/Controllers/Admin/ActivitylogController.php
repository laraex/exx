<?php

namespace App\Http\Controllers\Admin;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ActivitylogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin1']);
    }

    public function index(Request $request)
    {
        $loglists = ActivityLog::with('loguser')->orderBy('id', 'DESC');
        $q = Input::get ('q');
        $from_date = date('Y-m-d H:i:s',strtotime($request->from_date));
        $to_date = date('Y-m-d H:i:s',strtotime($request->to_date));

        if($q != "")
        {
            $searchlog = $loglists->where('log_name','LIKE','%'.$q.'%')->orWhere('description','LIKE','%'.$q.'%')->orwhereHas('loguser', function ($query) use ($q) {
                          $query->where('name', 'LIKE', '%' . $q . '%');
                    })->paginate(20)->setPath('');

            $pagination = $searchlog->appends(array('q' => Input::get('q')));
  
            if (count($searchlog)>0)
                return view('admin.showactivitylogs',[
                    'searchlog' => $searchlog])->withQuery($q);
            else
            {
                $searchlog = $loglists->paginate('20'); 
                return view ('admin.showactivitylogs',[
                        'searchlog' => $searchlog,
                ]);
            }
        }

        if ($from_date != "" && $to_date != "" && isset($request->from_date)) 
        {
            Validator::extend('checkdate', function ($attribute, $value, $parameters, $validator) 
            {   
                $from_date = date('Y-m-d H:i:s',strtotime(Input::get('from_date')));
                $to_date = date('Y-m-d H:i:s',strtotime(Input::get('to_date')));

                if($from_date <= $to_date)
                {
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

            $searchlog = $loglists->whereBetween('created_at',[$from_date,$to_date])->paginate(20);
        }  
        else
        {
            $searchlog = $loglists->paginate('20');                     
        }
        return view('admin.showactivitylogs',[
                        'searchlog' => $searchlog,
            ]);
    }

}
