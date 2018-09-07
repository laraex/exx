<?php

namespace App\Mail;

use App\Models\Userprofile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Mailtemplate;

class ResetUserTransactionPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $userprofile;
    protected $token;

    public function __construct(Userprofile $userprofile, $token)
    {
        $this->userprofile = $userprofile; 
        $this->token = $token; 

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = $this->userprofile->user->name;
        // return $this->markdown('emails.admin.resettransactionpassword')->with([ 
        //     'name' => $name,
        //     'token' => $this->token,  
        //     'resetlink' => url('myaccount/changepassword'),
        //     'resetlinktext' => trans('mail.resetlinktext'),
        //     'signature' => trans('mail.signature'),
        // ]);

        $kycverified = Mailtemplate::where([['name','reset_user_transaction_password'],['status','active']])->first();

        $url = url('myaccount/changepassword');

        $subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;

        $mail_content = str_replace(":name",$name,$mail_content);
        $mail_content = str_replace(":token",$this->token,$mail_content);
        $mail_content = str_replace(":resetlink",$url,$mail_content);

        return $this->markdown('emails.mailcontent')
                    ->subject($subject)
                    ->with([
                        'content' => $mail_content,
                        ]);
        
    }
}
