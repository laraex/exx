<?php

namespace App\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Models\Userprofile;
use App\Models\Mailtemplate;

class UserNotifyKycVerify extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

     /**
     * The transaction instance.
     *
     * @var transaction
     */
    protected $userprofile,$proof;

    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Userprofile $userprofile,$proof)
    {
        $this->userprofile = $userprofile;
        $this->proof = $proof;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    { 
        $admin = User::find(1);
        // return $this->markdown('emails.KYC.usernotifykycverify')
        //             ->with([
        //                 'admin' => $admin->name,
        //                 // 'message' => trans('mail.admin_notify_kyc_verify_content', ['name' => $this->userprofile->user->name] ),
        //                 'name' => $this->userprofile->user->name,
        //                 'signature' => trans('mail.signature'),
        //                 // 'actionText' => trans('mail.click_to_login'),                   
        //                 // 'actionUrl' => url('/admin/users')
        // ]);



        $kycverified = Mailtemplate::where([['name','user_notify_kycverify'],['status','active']])->first();
        $subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;

        $mail_content = str_replace(":name",$this->userprofile->user->name,$mail_content);
        $mail_content = str_replace(":proof",$this->proof,$mail_content);

        return $this->markdown('emails.mailcontent')
                    ->subject($subject)
                    ->with([
                        'content' => $mail_content,
                        ]);
    }
}
