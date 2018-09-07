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

class AdminNotifyNewTicket extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

     /**
     * The User instance.
     *
     * @var User
     */
    protected $ticket;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {  
        $admin = User::find(1);       
        $user = User::where('id', $this->ticket->user_id)->first();
        $staff = User::where('id', $this->ticket->agent_id)->first();
        $status = TicketStatus::where('id', $this->ticket->status_id)->first();
        $priority = TicketPriorities::where('id', $this->ticket->priority_id)->first();
        $category = TicketCategories::where('id', $this->ticket->category_id)->first();

        // return $this->markdown('emails.ticket.adminnotifyticket')
        //             ->with([  
        //                 'name' => $admin->name,                      
        //                 'user' => $user->name,
        //                 'staff' => $staff->name,
        //                 'subject' => $this->ticket->subject,
        //                 'content' => rawurldecode($this->ticket->content),  
        //                 'status' => $status->name,
        //                 'priority' => $priority->name,
        //                 'category' => $category->name,                                
        //                 'signature' => trans('mail.signature'),
        //                 'actionText' => trans('mail.click_to_login'),                   
        //                 'actionUrl' => url('/login')
        //             ]);


        $kycverified = Mailtemplate::where([['name','admin_notify_new_ticket'],['status','active']])->first();
        $url = url('/login');

        $subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;

        $mail_content = str_replace(":name",$admin->name,$mail_content);
        $mail_content = str_replace(":user",$user->name,$mail_content);
        $mail_content = str_replace(":category",$category->name,$mail_content);
        $mail_content = str_replace(":priority",$priority->name,$mail_content);
        $mail_content = str_replace(":status",$status->name,$mail_content);
        $mail_content = str_replace(":staff",$staff->name,$mail_content);
        $mail_content = str_replace(":subject",$this->ticket->subject,$mail_content);
        $mail_content = str_replace(":content",rawurldecode($this->ticket->content),$mail_content);
        $mail_content = str_replace(":url",$url,$mail_content);

        return $this->markdown('emails.mailcontent')
                    ->subject($subject)
                    ->with([
                        'content' => $mail_content,
                        ]);
    }
}
