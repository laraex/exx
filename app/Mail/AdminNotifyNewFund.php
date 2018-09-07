<?php

namespace App\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Models\Transaction;
use App\Models\Usercurrencyaccount;
use App\Models\Mailtemplate;

class AdminNotifyNewFund extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

     /**
     * The transaction instance.
     *
     * @var transaction
     */
    protected $transaction,$user;

    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction,$user)
    {
        $this->transaction = $transaction;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    { 
        
        $name = $this->user->name;
        
        if(!is_null($this->user->userprofile->firstname) && !is_null($this->user->userprofile->lastname))
        {
            $name = $this->user->userprofile->firstname.' '. $this->user->userprofile->lastname;
        } 
       // $account_id = $this->transaction->account_id;
        $currency = $this->transaction->present()->getCurrencyName($this->transaction->account_id);
        //$currency = Usercurrencyaccount::where('id', $account_id)->with('currency')->first();
         // return $this->markdown('emails.fund.adminnotifynewfundadded')
         //            ->with([
         //                'content' => trans('mail.admin_notify_new_deposit_content', ['username' => $name] ),
         //                'deposited_amount' => $this->transaction->amount,
         //                'currency' => $currency,
         //                'signature' => trans('mail.signature'),
         //            ]);


        $kycverified = Mailtemplate::where([['name','admin_notify_new_fund'],['status','active']])->first();
        $subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;

        $mail_content = str_replace(":name","Admin",$mail_content);
        $mail_content = str_replace(":username",$name,$mail_content);
        $mail_content = str_replace(":deposited_amount",$this->transaction->amount,$mail_content);
        $mail_content = str_replace(":currency",$currency,$mail_content);

        return $this->markdown('emails.mailcontent')
                    ->subject($subject)
                    ->with([
                        'content' => $mail_content,
                        ]);
    }
}
