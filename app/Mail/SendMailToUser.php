<?php

namespace App\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\SendMail;
use App\Models\Mailtemplate;

class SendMailToUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

	/**
     * The User instance.
     *
     * @var User
     */
    protected $sendmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SendMail $sendmail)
    {

       $this->sendmail = $sendmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::where('id', $this->sendmail->user_id)->first();
      
        // return $this->subject($this->sendmail->subject)->markdown('emails.admin.sendmail')->with([                                           
        //     'username' => $user->name,   
        //     'message' => $this->sendmail->message,                                             
        //     'signature' => trans('mail.signature'),
                        
        // ]);

        $kycverified = Mailtemplate::where([['name','send_mail_touser'],['status','active']])->first();

        //$subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;

        $mail_content = str_replace(":name",$user->name,$mail_content);
        $mail_content = str_replace(":message",$this->sendmail->message,$mail_content);

        return $this->markdown('emails.mailcontent')
                    ->subject($this->sendmail->subject)
                    ->with([
                        'content' => $mail_content,
                        ]);
    }
}