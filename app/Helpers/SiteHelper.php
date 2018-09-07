<?php

namespace App\Helpers;
use App\Models\Userprofile;
use App\Exchangerate;

class SiteHelper
{   
    public static function is_admin($userid)
    {
        if ($userid == '')
        {
            return FALSE;
        }
        $userprofile = Userprofile::where('user_id', $userid)->first();  
        if($userprofile->usergroup_id == 1)
        {
            return TRUE;
        }
        return FALSE;
    }
   
    public static function is_user($userid)
    {
        if ($userid == '')
        {
            return FALSE;
        }
        $userprofile = Userprofile::where('user_id', $userid)->first(); 

        if($userprofile->usergroup_id == 3)
        {
            return TRUE;
        }
        return FALSE;
    }

     public static function is_staff($userid)
    {
        if ($userid == '')
        {
            return FALSE;
        }
        $userprofile = Userprofile::where('user_id', $userid)->first(); 

        if($userprofile->usergroup_id == 2)
        {
            return TRUE;
        }
        return FALSE;
    }

    public static function getBitcoinWalletDetails($hashkey)
    {     
        // $url = 'https://testnet.blockexplorer.com/api/tx/'.$hashkey; 
        $url = 'https://blockexplorer.com/api/tx/'.$hashkey;
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2); 
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl_json = curl_exec($ch);
        curl_close($ch);
        return $curl_json;
    }

    

    
}