<?php

namespace App\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Models\Mailtemplate;

class ResetTransactionPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The token instance.
     *
     * @var Token
     */
    protected $reset_transaction_password;
    protected $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reset_transaction_password,User $user)
    {
        $this->reset_transaction_password = $reset_transaction_password;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //$user = User::where('id', Auth::id())->with('userprofile')->first();
        //dd($user);

        $name = $this->user->name;

         if(!is_null($this->user->userprofile->firstname) && !is_null($this->user->userprofile->lastname))
         {
            $name = $this->user->userprofile->firstname.' '. $this->user->userprofile->lastname;
         }

        // return $this->markdown('emails.profile.reset-transactionpassword')
        //             ->with([ 

        //                'reset_transaction_password_content' => trans('mail.reset_transaction_password_content'),
        //                'reset_transaction_password_link' => url('myaccount/transactionpassword'),
        //                'transaction_password_link_text' => trans('mail.transaction_password_link_text'),
        //                'new_transaction_password_content' => trans('mail.new_transaction_password_content'),
        //                 'new_transaction_password' => $this->reset_transaction_password,
        //                 'name' => $name,  
        //                 'signature' => trans('mail.signature'),

        //             ]);

        $kycverified = Mailtemplate::where([['name','reset_transaction_password'],['status','active']])->first();

        $url = url('myaccount/transactionpassword');

        $subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;

        $mail_content = str_replace(":username",$name,$mail_content);
        $mail_content = str_replace(":new_transaction_password",$this->reset_transaction_password,$mail_content);
        $mail_content = str_replace(":reset_transaction_password_link",$url,$mail_content);

        return $this->markdown('emails.mailcontent')
                    ->subject($subject)
                    ->with([
                        'content' => $mail_content,
                        ]);

        
    }
}