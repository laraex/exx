<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TradetotalEvent implements ShouldBroadcast {
  
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $broadcastQueue = 'tradetotalevent';
    //public $channel;
    public $data;
   // public $wallet=array();
    /**
     * Create a new event instance.
     *
     * @return void
     */
   public function __construct($data)
   {

       //$this->channel = $channel;
       $this->data = $data;
   
   }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
      
        return new channel("tradetotal");
    }
    public function broadcastWith()
   {


    return [$this->data];

   }

}
