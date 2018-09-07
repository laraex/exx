<?php

namespace App\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Models\Userprofile;

class AdminNotifyKycVerify extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

     /**
     * The transaction instance.
     *
     * @var transaction
     */
    protected $userprofile;

    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Userprofile $userprofile)
    {
        $this->userprofile = $userprofile;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    { 
        // $admin = User::find(1);
        // return $this->markdown('emails.admin.adminnotifykycverify')
        //             ->with([
        //                 'admin' => $admin->name,
        //                 'message' => trans('mail.admin_notify_kyc_verify_content', ['name' => $this->userprofile->user->name] ),
        //                 // 'username' => $this->userprofile->user->name,
        //                 'signature' => trans('mail.signature'),
        //                 'actionText' => trans('mail.click_to_login'),                   
        //                 'actionUrl' => url('/admin/users')
        // ]);
        $admin = User::find(1);
        $url=url('/admin/users');
        $kycverified = Mailtemplate::where([['name','admin_notify_kyc_verified'],['status','active']])->first();
        $subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;

        $mail_content=str_replace(":name",$admin->name,$mail_content);
        $mail_content=str_replace(":username",$this->userprofile->user->name,$mail_content);
        $mail_content=str_replace(":url",$url,$mail_content);

        return $this->markdown('emails.mailcontent')
                    ->subject($subject)
                    ->with([
                        'content' => $mail_content,
                        ]);
    }
}
