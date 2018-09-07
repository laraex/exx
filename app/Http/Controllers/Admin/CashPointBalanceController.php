<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Currency;
class CashPointBalanceController extends Controller
{
      
    public function index()
    {
      
       $users = User::ByUserType('3')->with('userprofile','useraccount')->paginate('10');
       $currency = Currency::get()->keyby('id');
      return view('reports.cashpoint',[
        'users' => $users,
        'currency' => $currency,
      ]);
  }

}
