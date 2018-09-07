<?php

namespace App\Mail;
use App\Models\Contact;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Userprofile;
use App\Models\Mailtemplate;

class Contactus extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The contact instance.
     *
     * @var Contact
     */
    protected $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //dd($this->contact);
        // return $this->markdown('emails.contact')
        //             ->with([
        //                 'contactno' => $this->contact->contactno,
        //                 'skypeid' => $this->contact->skype_gtalk,
        //                 'queries' => $this->contact->queries,
        //                 'fromname' => $this->contact->fullname,
        //                 'signature' => trans('mail.user_signature', array('name' => $this->contact->fullname))
        //             ]);


        $kycverified = Mailtemplate::where([['name','contact_us'],['status','active']])->first();
        $subject =  $kycverified->subject;
        $mail_content = $kycverified->mail_content;

        $mail_content = str_replace(":contactno",$this->contact->contactno,$mail_content);
        $mail_content = str_replace(":skypeid",$this->contact->skype_gtalk,$mail_content);
        $mail_content = str_replace(":queries",$this->contact->queries,$mail_content);
        $mail_content = str_replace(":fromname",$this->contact->fullname,$mail_content);
        $mail_content = str_replace(":name","Admin",$mail_content);

        return $this->markdown('emails.mailcontent')
                    ->subject($subject)
                    ->with([
                        'content' => $mail_content,
                        ]);

    }
}
