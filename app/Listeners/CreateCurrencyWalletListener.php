<?php

namespace App\Listeners;

use App\Events\CreateCurrencyWallet;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Traits\CurrencyProcess;
class CreateCurrencyWalletListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    use CurrencyProcess;
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CreateCurrencyWallet  $event
     * @return void
     */
    public function handle(CreateCurrencyWallet $event)
    {
        //
        $this->createCurrencyWallets($event->currency_data); 
    }
}
