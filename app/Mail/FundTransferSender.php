<?php

namespace App\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Models\Fundtransfer;
use App\Models\Usercurrencyaccount;
use App\Models\Mailtemplate;

class FundTransferSender extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

     /**
     * The transaction instance.
     *
     * @var transaction
     */
    protected $result;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Fundtransfer $result)
    {
        $this->result = $result;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    { 
        $fromuser = Usercurrencyaccount::where('id', $this->result->from_account_id)->with('currency')->first();
        $senderID = $fromuser->user_id;
        $sender = User::where('id', $senderID)->first();
        $touser = Usercurrencyaccount::where('id', $this->result->to_account_id)->first();
        $receiverID = $touser->user_id;
        $receiver = User::where('id', $receiverID)->first();
        // return $this->markdown('emails.fundtransfer.fundtransfersender')
        //             ->with([
        //                 'amount' => $this->result->amount,
        //                 'currency' => $fromuser->currency->name,
        //                 'sender' => $sender->name,
        //                 'receiver' => $receiver->name,
        //                 'signature' => trans('mail.signature'),
        //             ]);

        $kycverified = Mailtemplate::where([['name','fund_transfer_sender'],['status','active']])->first();
        $subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;

        $mail_content = str_replace(":name",$sender->name,$mail_content);
        $mail_content = str_replace(":amount",$this->result->amount,$mail_content);
        $mail_content = str_replace(":currency",$fromuser->currency->name,$mail_content);
        $mail_content = str_replace(":receiver",$receiver->name,$mail_content);
        
        return $this->markdown('emails.mailcontent')
                    ->subject($subject)
                    ->with([
                        'content' => $mail_content,
                        ]);
    }
}
