<?php 

namespace App\Traits;

use App\User;
use App\Deposit;
use App\Userprofile;
use App\Placement;
use Illuminate\Support\Facades\Config;
use App\Traits\Common;



trait PlacementProcessor {

    use Common;
            public function processPlacement (User $user) {

            $default_sponsor=$this->getSettingValue('default_sponsor');  
            $root  = User::where('email', $default_sponsor)->first();
         
            $sponsor = $this->findMySponsor($user);
            //$sponsorExists = $this->checkSponsorExists($sponsor);
            $sponsorExists = true;
            $width=$this->getSettingValue('matrix_width');
           

                    if ($sponsorExists) {
                        $updatedNode = $this->locateNode($sponsor, $user);
                        return $updatedNode;
                    }else {
                        $updatedNode = $this->locateNode($root, $user);
                        return $updatedNode;
                    } 
         
             
        }

         public function updateSpillover(User $sponsor, User $user){

            $sponsorRoot = $sponsor->placement->root_id;
            $newRoot = $sponsorRoot +1 ;
            $spilloverref = $sponsor->id;
            $alphakey= $sponsor->placement->alphakey."-"."B".$user->id;
          
                    $placement = new Placement();                   
                    $placement->user_id = $user->id;
                    $placement->spillover_id = $spilloverref;
                    $placement->root_id = $newRoot; 
                    $placement->active = "1";
                    $placement->alphaKey =$alphakey;                   
                    $placement->save();  


                
        }

        public function locateNode(User $sponsor, User $user){
          
            $sponsorRoot = $sponsor->placement->root_id;          
            $newRoot = $sponsorRoot +1 ;          
            $alphakeyref = $sponsor->placement->alphakey; 
            //var_dump($alphakeyref);          
            $userPlaced = $this->checkUserPlaced($user); 
           /* $alphakey= $alphakeyref."-"."B".$user->id; */         
            $width=$this->getSettingValue('matrix_width'); 

            if (!$userPlaced) {
                    /*$openNode = Placement::whereRaw(" `root_id` >= '$newRoot'  AND `alphakey` like '%".$alphakeyref."' AND `user_id` IS NULL  ")->orderby('id','ASC')->first(); */   
                    $openNode = Placement::whereRaw("  `alphakey` like '%".$alphakeyref."' AND `user_id` IS NULL  ")->orderby('id','ASC')->first();

                    //var_dump($openNode->alphakey);
                     $openNode = Placement::whereRaw(" `alphakey` like '".$alphakeyref."%' AND `user_id` IS NULL  ")->orderby('root_id','ASC')->orderby('id','asc')->first();

                     $alphakey_ref = $openNode->alphakey;  
                     $alphakey= $alphakey_ref."-"."B".$user->id; 

                    $openNode->user_id = $user->id;
                    $openNode->alphaKey =$alphakey; 
                    $openNode->active = "1";
                    $openNode->save();
                    $newSponsor = User::where('id', $openNode->user_id)->first();
                    $spilloverExists = $this->checkSpilloverExists($newSponsor);

                    $width=$this->getSettingValue('matrix_width'); 
                    if($width>0)
                    {
                        if(!$spilloverExists) {
                                    $this->populateChild($newSponsor,'',$openNode);
                        }

                    }
                    else
                    {
                            $width=$width+1;
                            $this->populateChild($newSponsor,'-1',$openNode);

                    }
                }
        }
        public function populateChild ($sponsor,$limit,$openNode) {

            $width=$this->getSettingValue('matrix_width'); 

                     
                    
            $alphakey = $sponsor->placement->alphakey;
            $spilloverref = $sponsor->placement->user_id;
            $newRoot = $sponsor->placement->root_id+1;

            if($limit==-1)
            {
                $width=$width+1;
                $alphakey_up = $openNode->alphakey;
                $newRoot_up = $openNode->root_id;

                $spilloverref_up= $openNode->spillover_id;               

                $this->populateNode($newRoot_up,0,$alphakey_up,$spilloverref_up);


            }

            for($loop =0; $loop <  $width; $loop++){

                   $this->populateNode($newRoot,0,$alphakey,$spilloverref);
                  
                };
        }
        public function populateNode($root_id,$active,$alphakey,$spillover_id)
        {

                    $placement = new Placement;
                    $placement->root_id = $root_id;
                    $placement->active = $active;                  
                    $placement->alphakey = $alphakey ;
                    $placement->spillover_id = $spillover_id;
                    $placement->save();
                    return $placement;

        }

               


        public function findMySponsor (User $user) {
                $user_id = $user->id;
                $sponsor_id = $user->sponsor->id;
                $sponsor = User::where('id', $sponsor_id)->with('placement')->first();
               
                return $sponsor;
        }

        public function checkSponsorRootIdExists($sponsorRoot) {
            $newRoot = $sponsorRoot+1;
            return Placement::where('root_id', $sponsorRoot )->exists();
        }

        public function checkUserPlaced ($user) {
            return Placement::where('user_id', $user->id)->exists();
        }

        public function checkSponsorExists($sponsor) {
            return Placement::where('user_id', $sponsor->id)->exists();
        }
        
        public function checkRootExists ($sponsor) {
            return Placement::where('root_id', $sponsor->placement->root_id+1 )->exists();
        }

        public function checkSpilloverExists ($sponsor) {
            return Placement::where('spillover_id', $sponsor->id )->exists();
        }
}