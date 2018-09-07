<?php

namespace App\Http\Controllers\Myaccount;

use Illuminate\Http\Request;
use App\Models\Userprofile;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use App\Http\Requests\KYCFinancialRequest;
use App\Http\Requests\KYCRequest;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\KYCUploadSuccessful;
use App\Traits\LogActivity;
use App\UserInformation;
use App\Http\Requests\SourceRequest;

class KYCController extends Controller
{   
    use LogActivity;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userprofile = Userprofile::where('user_id', Auth::id() )->with('user')->first();
       return view ('kyc.create',[
       'userprofile' => $userprofile,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(KYCRequest $request)
    {
        //dd($request);
        $folder='KYC';
        $userprofile = Userprofile::where('user_id', Auth::id() )->with('user')->first();
        
        if (!is_null($request->file('passport_attachment')))
        {
            if ($request->file('passport_attachment')->isValid())
            {                
                $file = $request->passport_attachment;
            
                $passport_attachment=$this->uploadKYC($folder,$file,$userprofile);
              }

        }if (!is_null($request->file('id_card_attachment')))
        {
            if ($request->file('id_card_attachment')->isValid())
            {                
                $file = $request->id_card_attachment;
            
                $id_card_attachment=$this->uploadKYC($folder,$file,$userprofile);
              }

        }if (!is_null($request->file('driving_license_attachment')))
        {
            if ($request->file('driving_license_attachment')->isValid())
            {                
                $file = $request->driving_license_attachment;
            
                $driving_license_attachment=$this->uploadKYC($folder,$file,$userprofile);
              }

        }if (!is_null($request->file('photo_id_attachment')))
        {
            if ($request->file('photo_id_attachment')->isValid())
            {                
                $file = $request->photo_id_attachment;
            
                $photo_id_attachment=$this->uploadKYC($folder,$file,$userprofile);
              }

        }
                 

      
        $proof='';
        if (!is_null($request->file('passport_attachment')))
        {
            $userprofile->passport = $request->passport;
            $userprofile->passport_attachment = $passport_attachment;
            $userprofile->passport_verified = 0;
            $proof.= "Passport,";
        }
        
        if (!is_null($request->file('id_card_attachment')))
        {
            $userprofile->id_card = $request->id_card;
            $userprofile->id_card_attachment = $id_card_attachment;
            $userprofile->id_card_verified = 0;
            $proof.= "ID Card,";
        }
        if (!is_null($request->file('driving_license_attachment')))
        {
           $userprofile->driving_license = $request->driving_license;
           $userprofile->driving_license_attachment = $driving_license_attachment;
           $userprofile->driving_license_verified = 0;
          $proof.= "Driving License,";
        }
        if (!is_null($request->file('photo_id_attachment')))
        {
            $userprofile->photo_id = $request->photo_id;
            $userprofile->photo_id_attachment = $photo_id_attachment;
            $userprofile->photo_id_verified = 0;
            $proof.= "Photo ID";
        }

 
        $userprofile->save();


        $user = User::where('id', Auth::id())->with('userprofile')->first();
        $message = 'KYC Uploaded - '.$proof;
        $this->doActivityLog(
                    $user,
                    $user,
                    ['ip' => request()->ip()],
                    LOGNAME_KYC,
                    $message
                );

        $admin = User::find(1);

         Mail::to($admin->email)->queue(new KYCUploadSuccessful($userprofile, $proof));


        $request->session()->flash('successmessage', trans('forms.kyc_success_message'));
             
        return Redirect::to( url('/myaccount/kyc')); 
                      
      
   
    }

    public function uploadKYC($folder,$file,$userprofile)
    {
       $destination_Path ="/".$folder."/";
       $destinationPath =base_path().$destination_Path;
      

        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $filerename = $userprofile->user->name."_".$filename.'_'.time().'.'.$extension;
        $file->move($destinationPath, $filerename);       
        $path = $destination_Path.$filerename; 

        return $path;
    }
    public function create_financial()
    {   
       $userprofile = Userprofile::where('user_id', Auth::id() )->with('user')->first();
       $country = Country::get(); 
       $bankdata=json_decode($userprofile->bank_data);    

       return view ('kyc.create_financial',[
         'country' => $country,
         'userprofile' => $userprofile,
         'bankdata' => $bankdata,
        ]);

    }
     public function store_financial(KYCFinancialRequest $request)
    {
        $folder='KYC/financial';
        $userprofile = Userprofile::where('user_id', Auth::id() )->with('user')->first();
        
        if (!is_null($request->file('bank_attachment')))
        {
            if ($request->file('bank_attachment')->isValid())
            {                
                $file = $request->bank_attachment;
            
                $bank_attachment=$this->uploadKYC($folder,$file,$userprofile);
              }

        }   
        
        if (!is_null($request->file('bank_attachment')))
        {
            $userprofile->bank = 1;
            $userprofile->bank_attachment = $bank_attachment;
            $userprofile->bank_verified = 0;
        }
        
       $country=Country::find($request->country);
       $bank_data=[
           
            "bank_name"=>$request->bank_name,        
            "country"=>$country->name,
            "statement"=>$request->statement,
            "country_id"=>$request->country,
           
            ];

       $bank_data=json_encode($bank_data);
       $userprofile->bank_data = $bank_data;
          
        $userprofile->save();

        $user = User::where('id', Auth::id())->with('userprofile')->first();
        $message = 'KYC Financial Uploaded';
        $this->doActivityLog(
                    $user,
                    $user,
                    ['ip' => request()->ip()],
                    LOGNAME_KYCFINANCIAL,
                    $message
                );


        $request->session()->flash('successmessage', trans('forms.kyc_financialsuccess_message'));
             
        return Redirect::to( url('/myaccount/financial')); 
      
   
    }

    public function create_investment()
    {       
        $country = Country::get();
        $information = UserInformation::where('user_id', Auth::id())->with('user')->first();
        //dd($information);
        $userprofile = Userprofile::where('user_id', Auth::id() )->with('user')->first();
        return view ('kyc.create_investment',[   
            'country' => $country,
            'information' => $information,
            'userprofile' => $userprofile,
        ]);
    }
    public function store_investment(SourceRequest $request)
    {
        $source = $request->source;
        $source = implode(',',$source);
        $update = [
            'user_id'=>Auth::id(),
            'status'=>$request->status,
            'title'=>$request->title,
            'name'=>$request->name,
            'state'=> $request->state,
            'district'=>$request->district,
            'street'=>$request->street,
            'source'=>$source,                            
            'net_amount'=>$request->net_amount,
            'industry'=>$request->industry,
            'country'=>$request->country,
            'city'=>$request->city,
            'number'=>$request->number,
            'zip'=>$request->zipcode,
            'investment'=>$request->investment,
            'q1'=>$request->invest_stock,
            'q2'=>$request->investment_exp,
            'q3'=>$request->investment_exp_market,
            'q4'=>$request->derivative,
            'q5'=>$request->crypto_currencies,
            
        ];
       UserInformation::where('id',Auth::id())->update($update);

       $request->session()->flash('successmessage',trans('forms.kyc_investmentsuccess_message'));
             
        return Redirect::to( url('/myaccount/investment')); 

    }
}
