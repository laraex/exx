<?php

namespace App\Listeners;

use App\Events\OrderApproveEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderApproveListener
{
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
     * @param  OrderApproveEvent  $event
     * @return void
     */
    public function handle(OrderApproveEvent $event)
    {
        //
    }
}
