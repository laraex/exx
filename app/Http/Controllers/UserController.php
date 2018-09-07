<?php

namespace App\Http\Controllers;

use App\Helpers\SiteHelper;
use App\Models\Userprofile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller {
	/**
	 * Admin impersonate a user
	 *
	 * @param [type] $id
	 * @return void
	 */
	public function impersonate($id) {
		$user = User::find($id);
		$is_admin = SiteHelper::is_admin($user->id);
		if (!$is_admin) {
			Auth::user()->setImpersonating($user->id);
		} else {
			flash()->error('Impersonate disabled for this user.');
		}
		if ($user->userprofile->usergroup_id == 2) {
			//dd("GG");
			return redirect(url('staff/dashboard'));
		} else {
			return redirect('/');
		}
	}

	/**
	 * Admin logs out of user
	 *
	 * @return void
	 */
	public function stopImpersonate() {
		// dd(Auth::user()->id);
		$user = User::where('id', Auth::user()->id)->with('userprofile')->first();
		Auth::user()->stopImpersonating();
		echo $user->userprofile->usergroup_id;
		if ($user->userprofile->usergroup_id == 2) {
			return redirect(url('admin/staffs'));
		} elseif ($user->userprofile->usergroup_id == 3) {
			return redirect(url('admin/users'));
		} elseif ($user->userprofile->usergroup_id == 1) {
			return redirect(url('admin/dashboard'));
		}

	}
	//Add to favourite
	public function favourite(Request $request) {

		$userprofile = Userprofile::where('user_id', Auth::id())->with('user')->first();
		$old = explode(',', $userprofile->fav_pair);
		if (($key = array_search($request->body['pair'], $old)) !== false) {
			unset($old[$key]);
			$userprofile->fav_pair = implode(',', $old);
		} else {
			array_push($old, $request->body['pair']);
			$userprofile->fav_pair = implode(',', $old);
		}

		$userprofile->save();
		return $userprofile;

	}
}