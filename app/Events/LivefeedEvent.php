<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LivefeedEvent  implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $transaction=array();

   // public $transaction;

    public function __construct($transaction)
    {
       // $this->transaction = $transaction;
        $this->transaction = $transaction;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
     return new channel('livefeed');
      //  return ['livefeed'];
      //  return new channel('livefeed');
//return new PrivateChannel('livefeed');

    }

    public function broadcastWith()
{

   // return ['transaction' => $this->transaction];
//return ['transaction' => 'jkjkjk'];
    return [$this->transaction];

}
}
