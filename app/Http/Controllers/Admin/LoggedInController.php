<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Session;
use Illuminate\Support\Facades\Auth;

class LoggedInController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin1']);
    }

    public function index()
    {
        $loggedinlist = Session::whereNotNull('user_id')->where('user_id','!=',Auth::id())->orderBy('id', 'DESC')->get();
  
        return view('admin.show_loggedin_list', [
                        'loggedinlist' => $loggedinlist
            ]);
    }

}
