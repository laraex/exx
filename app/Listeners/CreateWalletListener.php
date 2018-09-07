<?php

namespace App\Listeners;

use App\Events\CreateWallet;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Traits\RegistersNewUser;
use App\Traits\Common;

class CreateWalletListener implements ShouldQueue
{
    use RegistersNewUser,Common;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    
    }

    /**
     * Handle the event.
     *
     * @param  CreateWallet  $event
     * @return void
     */
    public function handle(CreateWallet $event)
    {
        //
    
             $this->createWallets($event->user); 

    }
}
