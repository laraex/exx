<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\Contactus;

use Config;
use App\Models\Contact;
use Illuminate\Bus\Queueable;

class ContactController extends Controller
{
   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contactaddress = Config::get('settings.contact');

        $fullname = '';
        $email = '';
        $contactno = '';
        
        return view('contact.contact', [
            'contactaddress' => $contactaddress,
            'fullname'=> $fullname,
            'email'=>$email,
            'contactno'=>$contactno
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
       // dd($request);
        $contact = new Contact;
        $contact->fullname = $request->fullname;
        $contact->email = $request->emailid;
        $contact->contactno = $request->contactno;
        $contact->skype_gtalk = $request->socialaddress;
        // $contact->queries = rawurlencode($request->message);
        $contact->queries = $request->message;
          
        if ($contact->save()) {
            Mail::to(Config::get('settings.adminemail'))->queue(new Contactus($contact));
            $request->session()->flash('successmessage', trans('forms.contact_success_message'));
        } else {
            // foreach(Mail::failures as $email_address) {
            //    echo " - $email_address <br />";
            // }
            $request->session()->flash('errormessage', trans('forms.contact_failure_message'));
        }
        

        return back();
    }
}
