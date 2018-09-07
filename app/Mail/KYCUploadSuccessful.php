<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Userprofile;
use App\Models\Mailtemplate;

class KYCUploadSuccessful extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $userprofile, $proof;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Userprofile $userprofile, $proof)
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
    {   //dd($this->proof);
         // return $this->markdown('emails.KYC.kycuploadsuccessful')->with([
         //        'name' => $this->userprofile->user->name,
         //        'proof' => $this->proof,
         //        'signature' => trans('mail.signature'),


         //    ]);

        $kycverified = Mailtemplate::where([['name','kyc_upload_successfull'],['status','active']])->first();
        $subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;

        $mail_content = str_replace(":name","Admin",$mail_content);
        $mail_content = str_replace(":username",$this->userprofile->user->name,$mail_content);
        $mail_content = str_replace(":proof",$this->proof,$mail_content);

        return $this->markdown('emails.mailcontent')
                    ->subject($subject)
                    ->with([
                        'content' => $mail_content,
                        ]);
    }
}
