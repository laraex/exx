<?php

namespace App\Http\Controllers\admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\AuthenticationProcess;
use App\Http\Requests\OTPRequest;

class OTPController extends Controller
{
    use  AuthenticationProcess;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','admin1']);
    }

    public function generateotp() 
    {
        return view('admin.otp.verify');
    }    

    public function verifyotp(OTPRequest $request)
    {
        $this->updateotp($request);
        return redirect('/admin/dashboard');
    } 
}
