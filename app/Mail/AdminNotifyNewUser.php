<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Models\Mailtemplate;

class AdminNotifyNewUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

     /**
     * The User instance.
     *
     * @var User
     */
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->markdown('emails.admin.adminnotifynewuser')
        //             ->with([
                        
        //                 'registered_user_name' => $this->user->name,
        //                 'ip_address' => request()->ip(),
        //                 'message' => trans('mail.admin_notification_new_user_content'),                                  
        //                'signature' => trans('mail.signature'),
        //                'actionText' => trans('mail.click_to_login'),                   
        //                'actionUrl' => url('/admin/users')
        //             ]);

        $kycverified = Mailtemplate::where([['name','admin_notify_new_user'],['status','active']])->first();
        $url = url('/admin/users');

        $subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;
        
        $mail_content = str_replace(":name","Admin",$mail_content);
        $mail_content = str_replace(":username",$this->user->name,$mail_content);
        $mail_content = str_replace(":ip_address",request()->ip(),$mail_content);
        $mail_content = str_replace(":url",$url,$mail_content);

        return $this->markdown('emails.mailcontent')
                    ->subject($subject)
                    ->with([
                        'content' => $mail_content,
                        ]);
    }
}
