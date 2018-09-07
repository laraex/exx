<?php

namespace App\Http\Controllers\Staff;


use App\Models\Ticket;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {


    	$totaltickets = Ticket::where('agent_id', Auth::id())->count();

    	//dd($totalmembers);

    	return view('staff.dashboard', [
                'totaltickets' => $totaltickets
            ]);
    }
}
