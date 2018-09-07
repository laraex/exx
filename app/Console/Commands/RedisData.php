<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Redis;



class RedisData extends Command
{
       
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
   
    protected $signature = 'exchanger:redis {--delete}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Redis Delete Command';

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
       $redis=Redis::keys('*');
      // print_r($redis);
       
      // $redis_llen=Redis::llen('matrix15_myNetwork_2');
      // print_r($redis_llen);

      // $redis_del=Redis::del('matrix15_myNetwork_2');
       //print_r($redis_del);
        if ($this->option('delete')) {
           if(count($redis)>0)
           {
                   $redis_del=Redis::del($redis);
                   print_r($redis_del);
           }
           $this->info("Redis Cleared....");
       }
       else
       {
         print_r($redis);
       }
        
    }

}
