<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Models\Mailtemplate;

class OTP extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $otp;
    
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    { 
        $user = User::where('id', $this->otp['user_id'])->with('userprofile')->first();
        $name = $user->name;
         
        if(!is_null($user->userprofile->firstname) && !is_null($user->userprofile->lastname))
        {
            $name = $user->userprofile->firstname.' '. $user->userprofile->lastname;
        } 

        $otp = $this->otp['token'];
        $otplink = url('/admin/generateotp/');

        // return $this->markdown('emails.admin.otp') ->with([
        //     'name' => $name,
        //     'otp' => $otp,
        //     'otplink' => $otplink,
        //     'signature' => trans('mail.signature'),
        // ]);

        $kycverified = Mailtemplate::where([['name','otp'],['status','active']])->first();
        $subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;

        $mail_content = str_replace(":name",$name,$mail_content);
        $mail_content = str_replace(":otp",$otp,$mail_content);
        $mail_content = str_replace(":url",$otplink,$mail_content);

        return $this->markdown('emails.mailcontent')
                    ->subject($subject)
                    ->with([
                        'content' => $mail_content,
                        ]);
    }
}
