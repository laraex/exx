<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Userprofile;

class KYCReject extends Mailable implements ShouldQueue
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
        return $this->markdown('emails.admin.kycreject')
                    ->with([
                        'name' => $this->userdetails->firstname.' '. $this->userdetails->lastname,
                        'signature' => trans('mail.signature'),
                    ]);
    }
}
