<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\User;
use App\TradeOrders;
use App\Traits\TradeOrdersProcess;


class TradeOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
        use TradeOrdersProcess;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $trade;
    public function __construct($trade)
    {
        //
        $this->trade=$trade;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $this->checkTradeOrder($this->trade);

         

    }
    public function tags()
    {
        //
        $recent_activity = TradeOrders::where('id',$this->trade->id)->with('fromcurrency','tocurrency','user')->paginate(1);
        return ['trade', $this->trade->type .' order #'. $this->trade->id .' user #' . $this->trade->user_id];

    }
}
