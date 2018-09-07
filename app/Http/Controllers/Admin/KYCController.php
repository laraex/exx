<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Userprofile;
use File;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserNotifyKycVerify;
use App\Mail\UserNotifyKycReject;
use App\User;

class KYCController extends Controller
{
  public function __construct()
    {
        $this->middleware(['auth','admin1']);
    }

    public function proofDownload($proof,$id)
    {
        $attachment = Userprofile::where('id', '=', $id)->first();
        if($proof=='passport')
        {
            $path = base_path().$attachment->passport_attachment;
        }
       elseif($proof=='idcard')
        {
            $path = base_path().$attachment->id_card_attachment;
        }
       elseif($proof=='drivinglicense')
        {
            $path = base_path().$attachment->driving_license_attachment;
        }

       elseif($proof=='photoid')
        {
            $path = base_path().$attachment->photo_id_attachment;
        }
        elseif($proof=='bank')
        {
            $path = base_path().$attachment->bank_attachment;
        }
       // dd($path);
        $headers = array('Content-Type' => File::mimeType($path));        
        return response()->download($path, $attachment->attachment_file, $headers);
    }

    public function verify($proof,$id, Request $request)
    {
        $userprofile = Userprofile::where('id', '=', $id)->first();
//dd($userprofile);
        if($proof=='passport')
        {
          $userprofile->passport_verified = 1;
          $proof= "Passport";

        }
       elseif($proof=='idcard')
        {
           $userprofile->id_card_verified = 1;
           $proof= "ID Card";
        }
       elseif($proof=='drivinglicense')
        {
          $userprofile->driving_license_verified = 1;
          $proof= "Driving License";
        }

       elseif($proof=='photoid')
        {
          $userprofile->photo_id_verified = 1;
          $proof= "Photo ID";
        }
        elseif($proof=='bank')
        {
          $userprofile->bank_verified = 1;
        }
        
        if($userprofile->save())
        {
          $user = User::where('id', $id)->with('userprofile')->first();

           if(($user->isKycApproved == 1)||($user->userprofile->kyc_approved==1))
           {
            //dd('dkf');
              $kycverified_status = Userprofile::where('id', '=', $id)->first();
            //dd($kycverified_status);
              $kycverified_status->kyc_verified_status =  1;
              //dd($kycverified_status->kyc_verified_status);
              $kycverified_status->save();
           }
            $request->session()->flash('successmessage', trans('forms.kyc_verified_success_message')); 
        }
        else
        {
            $request->session()->flash('errormessage', trans('forms.kyc_verified_failure_message')); 
        }
        Mail::to($userprofile->user->email)->queue(new UserNotifyKycVerify($userprofile,$proof));
        //dd($proof);
        return back();
    
    }

    public function reject($proof,$id, Request $request)
    {
     
        $userprofile = Userprofile::where('id', '=', $id)->with('user')->first();
        if($proof=='passport')
        {
           $userprofile->passport_verified = 2;
           $proof= "Passport";
        }
       elseif($proof=='idcard')
        {
           $userprofile->id_card_verified = 2;
           $proof= "ID Card";
        }
       elseif($proof=='drivinglicense')
        {
         $userprofile->driving_license_verified = 2;
         $proof= "Driving License";
        }

       elseif($proof=='photoid')
        {
           $userprofile->photo_id_verified = 2;
           $proof= "Photo ID";
        }
        elseif($proof=='bank')
        {
           $userprofile->bank_verified = 2;
        }

        if( $userprofile->save() )
        {
            
            $request->session()->flash('successmessage', trans('forms.kyc_rejected_success_message')); 
        }
        else
        {
            $request->session()->flash('errormessage', trans('forms.kyc_rejected_failure_message')); 
        }
        Mail::to($userprofile->user->email)->queue(new UserNotifyKycReject($userprofile,$proof));
        return back();
    
    }
    public function index()
    {
        $lists = Userprofile::whereNotIn('usergroup_id', array('1', '2'))
        ->where( function ( $query )
            {
                $query->where( 'passport_verified', '!=', '1' )
                      ->whereNotNull( 'passport_attachment' );
            })
        ->orwhere( function ( $query )
            {
                $query->where( 'id_card_verified', '!=', '1' )
                      ->whereNotNull( 'id_card_attachment' );
            })
         ->orwhere( function ( $query )
            {
                $query->where( 'driving_license_verified', '!=', '1' )
                      ->whereNotNull( 'driving_license_attachment' );
            })
          ->orwhere( function ( $query )
            {
                $query->where( 'photo_id_verified', '!=', '1' )
                      ->whereNotNull( 'photo_id_attachment' );
            })
           ->orwhere( function ( $query )
            {
                $query->where( 'bank_verified', '!=', '1' )
                      ->whereNotNull( 'bank_attachment' );
            })
        ->with('user')->paginate(20);

       // dd($lists);
       
        return view('admin.kyc.kyc', [
                        'lists' => $lists,
                  ]);
    }

    public function kyc_approved(Request $request,$id)
    {
      $userprofile = Userprofile::find($id);
      $userprofile->kyc_approved = 1;
      if($userprofile->save())
        {
          $request->session()->flash('successmessage', trans('forms.kyc_verified_success_message')); 
        }
        else
        {
          $request->session()->flash('errormessage', trans('forms.kyc_verified_failure_message')); 
        }
        return back();
    }
}

?>