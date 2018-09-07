<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Traits\TransactionProcess;
use App\Traits\RegistersNewUser;

class CreateAdminTransaction extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchanger:admintxn';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Admin Transaction';

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
       $user=User::find(ADMIN_ID);
       $this->usertransaction($user);
    }
}
