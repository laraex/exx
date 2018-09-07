<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use App\Traits\Common;
use App\Traits\RegistersNewUser;
use App\Models\Referralgroup;
use App\Traits\PlacementProcessor;



class CreateTestUser extends Command
{
        use  RegistersNewUser,PlacementProcessor;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
   
    protected $signature = 'exchange:testuser {username} {--count=1} {--sponsor=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a  Test User';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        

        $count = $this->option('count');
        $count = intval($count);
        $sponsor = $this->option('sponsor');
        $sponsor = intval($sponsor);
     

       
      


        for ($i=0; $i < $count; $i++) { 

        if($count > 1) {
             $username = $this->argument('username').$i;
        }else {
             $username = $this->argument('username');
        }
      
        $sponsorid ='';
          
        if($sponsor==1) {
            $sponsor_id = $this->ask('Enter the sponsor id');
           
        }
        else
        {
           

         $default_sponsor=$this->getSettingValue('default_sponsor');  
         $root  = User::where('email', $default_sponsor)->first();
         $sponsor_id = $root->id;

        }

    
     
        $defaultReferralGroup = Referralgroup::where('is_default', '1')->first()->id;
       
    

        $user = new User;
        $user->name = $username;
        $user->email =$username."@bitground.co.kr";
        $user->password = bcrypt($username);
        
        $user->referralgroup_id = $defaultReferralGroup;
        $user->sponsor_id = $sponsor_id;
   
        $user->save();

        $userprofile = $this->createuserprofile($user); 
        $placement = $this->processPlacement($user);
               
   
        $this->info("New user added {$user->name}! - User Id : {$user->id}");
   
       

        }
    }

}
