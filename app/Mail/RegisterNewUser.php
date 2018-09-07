<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Models\Mailtemplate;

class RegisterNewUser extends Mailable implements ShouldQueue
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
        //dd($this->user->name);
        // return $this->markdown('emails.registernewuser')
        //             ->with([  
        //                 'message' => trans('mail.new_user_registered_content'),                                 
        //                 'name' => $this->user->name,  
        //                 'signature' => trans('mail.signature'),
        //                 'actionText' => trans('mail.click_to_login'),                   
        //                 'actionUrl' => url('/login')
        //             ]);


        $kycverified = Mailtemplate::where([['name','register_new_user'],['status','active']])->first();

        $url=url('/login');

        $subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;

        $mail_content = str_replace(":name",$this->user->name,$mail_content);
        $mail_content = str_replace(":url",$url,$mail_content);

        return $this->markdown('emails.mailcontent')
                    ->subject($subject)
                    ->with([
                        'content' => $mail_content,
                        ]);
    }
}