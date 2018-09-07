<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Classes\charts\Ajax;

class ChartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        //
    }

  

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        return view('home.charts');
    }
    public function chart(Request $request)
    {       

       $action = isset($request->action) ? $request->action : NULL;

        $ajax = new Ajax();
        if (method_exists($ajax, $action))
          $ajax->$action();

    }
    

}
