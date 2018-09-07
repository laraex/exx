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

class FundAddedNewStatus extends Mailable implements ShouldQueue
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
        $response_json = json_decode($this->transaction->response, true);

        $name = $this->user->name;

        if(!is_null($this->user->userprofile->firstname) && !is_null($this->user->userprofile->lastname))
        {
            $name = $this->user->userprofile->firstname.' '. $this->user->userprofile->lastname;
        }
        // $account_id = $this->transaction->account_id;
        // $currency = Usercurrencyaccount::where('id', $account_id)->with('currency')->first();
        $currency = $this->transaction->present()->getCurrencyName($this->transaction->account_id);

        // return $this->markdown('emails.fund.newfundaddedsuccessfull')
        //         ->with([
        //             'amount' => $this->transaction->amount,
        //             'currency' => $currency,
        //             'name' => $name,
        //             'transaction_number' => $response_json['transaction_number'],
        //             'signature' => trans('mail.signature'),
        //         ]);

        $kycverified = Mailtemplate::where([['name','fund_add_new_status'],['status','active']])->first();
        $subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;

        $mail_content = str_replace(":amount",$this->transaction->amount,$mail_content);
        $mail_content = str_replace(":currency",$currency,$mail_content);
        $mail_content = str_replace(":name",$name,$mail_content);
        $mail_content = str_replace(":transaction_number",$response_json['transaction_number'],$mail_content);

        return $this->markdown('emails.mailcontent')
                    ->subject($subject)
                    ->with([
                        'content' => $mail_content,
                        ]);
    }
}
