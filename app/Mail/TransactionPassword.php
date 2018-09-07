<?php

namespace App\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Models\Mailtemplate;

class TransactionPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user;
    
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
        //$user = Auth::user();
        //dd($user);
        // return $this->markdown('emails.profile.transactionpassword')
        //             ->with([                        
        //                 'message' => trans('mail.transaction_password_changed'),
        //                 'name' => $this->user->name,  
        //                 'signature' => trans('mail.signature'),
        //             ]);

         $kycverified = Mailtemplate::where([['name','transaction_password'],['status','active']])->first();

        $subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;

        $mail_content = str_replace(":name",$this->user->name,$mail_content);
       
        return $this->markdown('emails.mailcontent')
                    ->subject($subject)
                    ->with([
                        'content' => $mail_content,
                        ]);
    }
}