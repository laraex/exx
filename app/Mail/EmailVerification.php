<?php

namespace App\Mail;
use App\Models\Userprofile;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Mailtemplate;

class EmailVerification extends Mailable implements ShouldQueue
{
     /**
     * The contact instance.
     *
     * @var Contact
     */
    protected $userprofile;


    use Queueable, SerializesModels;

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
        //dd($this->userprofile);
        // $user = User::find($this->userprofile->user_id);

        // return $this->markdown('emails.emailverification')
        //             ->with([
        //                 'link' => $this->userprofile->email_verification_code,
        //                 'name' => $user->name,
        //                 'signature' => trans('mail.signature'),
        //             ]);

        $user = User::find($this->userprofile->user_id);

        $kycverified = Mailtemplate::where([['name','email_verification'],['status','active']])->first();
        $url = url('emailverification/'.$this->userprofile->email_verification_code);
        $subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;

        $mail_content=str_replace(":url",$url,$mail_content);
        $mail_content = str_replace(":name",$user->name,$mail_content);

        return $this->markdown('emails.mailcontent')
                    ->subject($subject)
                    ->with([
                        'content' => $mail_content,
                        ]);

    }
}
