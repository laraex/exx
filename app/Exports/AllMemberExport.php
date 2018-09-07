<?php
namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Traits\UserInfo;
use Illuminate\Database\Eloquent\Collection;
use App\User;

class AllMemberExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
    public function view(): View
    {
    	 $users = User::with('userprofile')->UserGroup('3')->get();
    	   $userlists =new Collection;
        if(count($users) > 0)
        {
            //$csv->insertOne(['Username','Email','First Name','Last name','Country']);
            
            foreach($users as $user) 
            {
                $country='';
                    if(count($user->userprofile->usercountry)>0)
                    {
                       $country=$user->userprofile->usercountry->name;
                    }
               
                $userlists->push([
                "username"=>$user->name,
                "email"=>$user->email,
                "firstname" => $user->userprofile->firstname,
                "lastname" =>$user->userprofile->lastname,
                "country" =>$country
               ]);
            }
        }
       
         return view('admin.exports.memberlists', [
            'memberlists' =>$userlists
        ]); 
    }
}
