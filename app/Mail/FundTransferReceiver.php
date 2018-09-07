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

class FundTransferReceiver extends Mailable implements ShouldQueue
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
 
        // return $this->markdown('emails.fundtransfer.fundtransferreceiver')
        //             ->with([
        //                 'amount' => $this->result->amount,
        //                 'currency' => $fromuser->currency->name,
        //                 'receiver' => $receiver->name,
        //                 'sender' => $sender->name,
        //                 'signature' => trans('mail.signature'),
        //                 'actionText' => trans('mail.click_to_login'),  
        //                 'account_no' => $touser->account_no,                 
        //                 'actionUrl' => url('/myaccount/home')
        //             ]);


        $kycverified = Mailtemplate::where([['name','fund_transfer_receiver'],['status','active']])->first();

        $url = url('/myaccount/home');

        $subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;

        $mail_content = str_replace(":name",$receiver->name,$mail_content);
        $mail_content = str_replace(":amount",$this->result->amount,$mail_content);
        $mail_content = str_replace(":currency",$fromuser->currency->name,$mail_content);
        $mail_content = str_replace(":sender",$sender->name,$mail_content);
        $mail_content = str_replace(":url",$url,$mail_content);

        return $this->markdown('emails.mailcontent')
                    ->subject($subject)
                    ->with([
                        'content' => $mail_content,
                        ]);
    }
}
