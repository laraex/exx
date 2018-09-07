<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Models\Ticket;
use App\Models\TicketCategories;
use App\Models\TicketStatus;
use App\Models\TicketPriorities;
use App\Models\Mailtemplate;

class UserNotifyTicketStatus extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

     /**
     * The User instance.
     *
     * @var User
     */
    protected $statusresult;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ticket $statusresult)
    {
        $this->statusresult = $statusresult;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {         
        $user = User::where('id', $this->statusresult->user_id)->first();
        $staff = User::where('id', $this->statusresult->agent_id)->first();
        $status = TicketStatus::where('id', $this->statusresult->status_id)->first();
        $priority = TicketPriorities::where('id', $this->statusresult->priority_id)->first();
        $category = TicketCategories::where('id', $this->statusresult->category_id)->first();

        // return $this->markdown('emails.ticket.usernotifyticketstatus')
        //             ->with([                      
        //                 'name' => $user->name,
        //                 'staff' => $staff->name,
        //                 'subject' => $this->statusresult->subject,
        //                 'content' => rawurldecode($this->statusresult->content),  
        //                 'status' => $status->name,
        //                 'priority' => $priority->name,
        //                 'category' => $category->name,                                
        //                 'signature' => trans('mail.signature'),
        //                 'actionText' => trans('mail.click_to_login'),                   
        //                 'actionUrl' => url('/login')
        //             ]);


        $kycverified = Mailtemplate::where([['name','user_notify_ticket_status'],['status','active']])->first();
        $url = url('/login');

        $subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;

        $mail_content = str_replace(":name",$user->name,$mail_content);
        $mail_content = str_replace(":status",$status->name,$mail_content);
        $mail_content = str_replace(":staff",$staff->name,$mail_content);
        $mail_content = str_replace(":subject",$this->statusresult->subject,$mail_content);
        $mail_content = str_replace(":content",rawurldecode($this->statusresult->content),$mail_content);
        $mail_content = str_replace(":category",$category->name,$mail_content);
        $mail_content = str_replace(":priority",$priority->name,$mail_content);      
        $mail_content = str_replace(":url",$url,$mail_content);      

        
        return $this->markdown('emails.mailcontent')
                    ->subject($subject)
                    ->with([
                        'content' => $mail_content,
                        ]);
    }
}
