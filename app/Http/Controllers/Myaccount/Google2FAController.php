<?php

namespace App\Http\Controllers\Myaccount;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Crypt;
use Google2FA;
use Cache;
use \ParagonIE\ConstantTime\Base32;
// use Illuminate\Contracts\Auth\Authenticatable;
//use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Requests\ValidateSecretRequest;
use Session;

class Google2FAController extends Controller
{
	//use ValidatesRequests;

    public function __construct()
    {
        $this->middleware(['auth', 'member']);
    }

    public function twofactor()
    {
        return view('twofactor.twofactorsettings');
    }

    public function enableTwoFactor(Request $request)
    {
        //generate new secret
        $secret = $this->generateSecret();
        // dd($secret);
        //get user
        $user = $request->user();
        
        //encrypt and then save secret
        $user->google2fa_secret = Crypt::encrypt($secret);
        $user->save();

        //generate image for QR barcode
        $imageDataUri = Google2FA::getQRCodeInline(
            $request->getHttpHost(),
            $user->email,
            $secret
        );

        return view('twofactor.enableTwoFactor', [
            'image' => $imageDataUri,
            'secret' => $secret
        ]);
    }

    public function disableTwoFactor(Request $request)
    {
        $user = $request->user();

        //make secret column blank
        $user->google2fa_secret = null;
        $user->google2fa_secret_status = 0;
        $user->save();

        return view('twofactor.disableTwoFactor');
    }

    private function generateSecret()
    {
        $randomBytes = random_bytes(10);
        
        return Base32::encodeUpper($randomBytes); 
    }

    public function getValidateToken()
    {
        $user = User::where('id', Auth::id())->first();
        if (!is_null($user->google2fa_secret)) 
        {
            return view('twofactor.validate');
        }
        return redirect('login');
    }

    public function postValidateToken(ValidateSecretRequest $request)   
    {
    	$user = User::where('id', Auth::id())->first();
        //get user id and create cache key

        $user->google2fa_secret_status=1;
        $user->save();
        
        $userId = $user->id;
        $key    = $userId . ':' . $request->totp;

        //use cache to store token to blacklist
        Cache::add($key, true, 4);

        //login and redirect user
        Auth::loginUsingId($userId);

        return redirect(url('/myaccount/home'));
      //  return redirect()->intended($this->redirectTo);
    }

}
