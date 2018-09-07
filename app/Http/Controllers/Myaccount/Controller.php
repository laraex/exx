<?php

namespace App\Http\Controllers\Myaccount;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Userprofile;
use App\Useraccount;
use App\Deposit;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

     public function __construct()
    {
        $this->middleware(['auth', 'member']);
    }

     public function userinfo() {

     	$user = User::where('id', Auth::id())->with(['userprofile','useraccounts','deposits'])->first();

            $sponsor = User::where('id', $user->userprofile->sponsor_id)->first()->name;

            return [$user, $sponsor];
     }
}
