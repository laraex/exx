<?php
namespace App\Http\Controllers;

namespace App\Http\Controllers\Myaccount;

use Illuminate\Support\Facades\Auth;
use App\Traits\Common;
use App\Traits\RegistersNewUser;
use App\User;
use Illuminate\Http\Request;
use App\Models\Userpayaccounts;
use Illuminate\Routing\Controller;

class WalletController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  use Common, RegistersNewUser;
  public function __construct()
  {
    $this->middleware(['auth', 'member']);
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */

  public function create_btcwallet()
  {
    $user = User::where('id', Auth::id())->with('userprofile')->first();

    $pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');

    $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->first();

    if (count($user_accounts) == 0) {
      return $this->createBTCWallet($user);
    } else {
      return $user_accounts->btc_address;
    }

  }

  public function create_ltcwallet()
  {
    $user = User::where('id', Auth::id())->with('userprofile')->first();

    $pg = $this->getPgDetailsByGatewayName('ltc_blockio');
    //dd($pg);

    $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->first();
    

    if (count($user_accounts) == 0) {
      return $this->createLTCWallet($user);
    } else {
      return $user_accounts->ltc_address;
    }

  }
  public function create_dogewallet()
  {

    $user = User::where('id', Auth::id())->with('userprofile')->first();

    $pg = $this->getPgDetailsByGatewayName('dogecoin_blockio');

    $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->first();

    if (count($user_accounts) == 0) {
      return $this->createDOGEWallet($user);
    } else {
      return $user_accounts->doge_address;
    }

  }
  public function create_ethwallet()
  {

    $user = User::where('id', Auth::id())->with('userprofile')->first();

    $pg = $this->getPgDetailsByGatewayName('eth');

    $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->first();

    if (count($user_accounts) == 0) {
      return $this->createETHWallet($user);
    } else {
      return $user_accounts->doge_address;
    }

  }

  public function create_bchwallet()
  {

    $user = User::where('id', Auth::id())->with('userprofile')->first();

    $pg = $this->getPgDetailsByGatewayName('bch');

    $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->first();

    if (count($user_accounts) == 0) {
      return $this->createBCHWallet($user);
    } else {
      return $user_accounts->bch_address;
    }

  }
  public function create_xrpwallet(Request $request)
  {
    $user = User::where('id', Auth::id())->with('userprofile')->first();

    $pg = $this->getPgDetailsByGatewayName('xrp');

    $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->first();

    if (count($user_accounts) == 0) {
      return $this->createXRPWallet($user, $request->input('address'), $request->input('secret'));
    } else {
      return $user_accounts->xrp_address;
    }

  } 
  public function create_qtumwallet()
  {
    $user = User::where('id', Auth::id())->with('userprofile')->first();

    $pg = $this->getPgDetailsByGatewayName('qtum');

    $user_accounts = Userpayaccounts::getAccountDetails(Auth::id(), $pg->id)->first();

    if (count($user_accounts) == 0) {
      return $this->createQTUMWallet($user);
    } else {
      return $user_accounts->btc_address;
    }

  }
}
