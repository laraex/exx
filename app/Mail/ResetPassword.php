<?php

namespace App\Mail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Mailtemplate;

class ResetPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The token instance.
     *
     * @var Token
     */
    protected $token;

    /**
     * The userdetails instance.
     *
     * @var userdetails
     */
    protected $userdetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $userdetails, $token)
    {
        $this->userdetails = $userdetails; 
        $this->token = $token; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::where('id', Auth::id())->with('userprofile')->first();
        
        // return $this->markdown('emails.admin.resetpassword')
        //             ->with([
        //                 'resetlink' => url('/password/reset/'.$this->token),
        //                 'resetlinktext' => trans('mail.resetlinktext'),
        //                 'message' => trans('mail.reset_password_message'),
        //                 'username' => $this->userdetails->userprofile->firstname.' '. $this->userdetails->userprofile->lastname,                        
        //                 'signature' => trans('mail.signature'),
        //             ]);

        $kycverified = Mailtemplate::where([['name','reset_password'],['status','active']])->first();

        $url = url('/password/reset/'.$this->token);

        $subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;

        $mail_content = str_replace(":username",$this->userdetails->userprofile->firstname.' '. $this->userdetails->userprofile->lastname,$mail_content);
        $mail_content = str_replace(":resetlink",$url,$mail_content);

        return $this->markdown('emails.mailcontent')
                    ->subject($subject)
                    ->with([
                        'content' => $mail_content,
                        ]);
    }
}
