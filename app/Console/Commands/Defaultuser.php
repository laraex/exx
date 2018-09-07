<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Placement;
use App\Models\Referralgroup;
use App\Settings;
use App\Traits\RegistersNewUser;
use App\Traits\TransactionProcess;

class Defaultuser extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchanger:defaultuser {--default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Default User';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    use RegistersNewUser,TransactionProcess;
    
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
        
        $width = Settings::where('key', 'matrix_width')->pluck('value');
        $width = $width[0];

        if ($this->option('default')) {
            $username = "root";
            $email = "root@bitground.co.kr";
          //  $account_type = "business";
            $password=$username;  
        } else {
            $username = $this->ask('Enter the username');
            $password = $this->secret('Enter the password');
            $email = $this->ask('Enter the email');
           // $account_type=$this->ask('Enter the account_type,personal/business');
        }


      

        $defaultReferralGroup = Referralgroup::where('is_default', '1')->first()->id;
       


        $user = new User;
        $user->name = $username;
        $user->email =$email;
        $user->password = bcrypt($password);
       // $user->account_type = $account_type;
        $user->referralgroup_id = $defaultReferralGroup;
       

        $user->save();

        $this->info("Root user added {$user->name} - User Id : {$user->id}");

        $update=[
                    'value'=>$email,
                 ];
        Settings::where('key', 'default_sponsor')->update($update);

     
        $userprofile = $this->createuserprofile($user);

        $userprofile->email_verified = 1;
        $userprofile->save();

            $root = new Placement;
            $root->user_id = $user->id;
            $root->root_id = "0";
            $root->spillover_id = "0";
            $root->alphakey = "A";
            $root->active = "1";
            $root->save();
        
        
        if ($width==0) {
            $width=$width+1;
        }
    
      
        for ($i =0; $i  <  $width; $i++) {
                    $placement = new Placement;
                    $placement->root_id = 1;
                    $placement->spillover_id = $user->id;
                    $placement->alphakey = $root->alphakey;
                    $placement->active = "0";
                    $placement->save();
        };
    }
}
