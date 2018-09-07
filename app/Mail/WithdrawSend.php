<?php

namespace App\Mail;
use App\Models\Withdraw;
use App\User;
use App\Models\Userprofile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Mailtemplate;

class WithdrawSend extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

     /**
     * The contact instance.
     *
     * @var Withdraw
     */
    protected $withdraw, $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Withdraw $withdraw,$user)
    {
        $this->withdraw = $withdraw;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       // $user = User::where('id', Auth::id())->with('userprofile')->first();
        $name = $this->user->name;

        if(!is_null($this->user->userprofile->firstname) && !is_null($this->user->userprofile->lastname))
        {
            $name = $this->user->userprofile->firstname.' '. $this->user->userprofile->lastname;
        }
        $currency = $this->withdraw->transaction->present()->getCurrencyName($this->withdraw->transaction->account_id);

        // return $this->markdown('emails.withdraw.withdrawrequest')
        //             ->with([
        //                 'amount' => $this->withdraw->amount,
        //                 'name' => $name,
        //                 'currency' => $currency,
        //                 'user_signature' => trans('mail.user_signature')
        //             ]);

        $kycverified = Mailtemplate::where([['name','withdraw_send'],['status','active']])->first();
        
        $subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;

        $mail_content = str_replace(":username","Admin",$mail_content);
        $mail_content = str_replace(":name",$name,$mail_content);
        $mail_content = str_replace(":amount",$this->withdraw->amount,$mail_content);
        $mail_content = str_replace(":currency",$currency,$mail_content);
       
        return $this->markdown('emails.mailcontent')
                    ->subject($subject)
                    ->with([
                        'content' => $mail_content,
                        ]);
    }
}
