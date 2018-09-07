<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Userprofile;

class KYCApprove extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

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
    public function __construct(Userprofile $userdetails)
    {
        $this->userdetails = $userdetails; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.admin.kycapprove')
                    ->with([
                        'name' => $this->userdetails->firstname.' '. $this->userdetails->lastname,
                        'signature' => trans('mail.signature'),
                    ]);

//sowmi
        // $mail_content = str_replace(":name",$name->$this->userdetails->firstname.' '. $this->userdetails->lastname,$mail_content);

        // return $this->markdown('emails.mailcontent')
        //             ->subject($subject)
        //             ->with([
        //                 'content' => strip_tags($mail_content),
        //                 ]);

    }
}
