<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\CoinDistribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\DistributeCoinRequest;
use App\Http\Requests\DistributeCoinEditRequest;
use App\TradeOrders;
use App\Traits\TradeOrdersProcess;
use App\Settlement;
class TradeController extends Controller
{
   use TradeOrdersProcess;
   public function __construct()
    {
        $this->middleware(['auth','admin1']);
    }

    
    public function open()
    {

         $openlists = TradeOrders::where('user_id', '!=',TRADEPOT_ID)->Where('status','pending')->orderBy('id','DESC')->with('fromcurrency','tocurrency','user')->paginate(\Config::get('settings.pagecount'));
          return view ('admin.trade.open',[
            'openlists'=>$openlists


            ]);
    }
    
     public function closed()
    {

        //  $closedlists = TradeOrders::where('user_id', '!=',TRADEPOT_ID)->Where('type','order')->orWhere('status','cancel')->orderBy('id','DESC')->with('fromcurrency','tocurrency','order')->paginate(\Config::get('settings.pagecount'));
          $closedlists = TradeOrders::where('user_id', '!=',TRADEPOT_ID)->WhereIn('type',['buy','sell'])->Where('status','!=','pending')->orderBy('id','DESC')->with('fromcurrency','tocurrency','order')->paginate(\Config::get('settings.pagecount'));
          return view ('admin.trade.closed',[
            'closedlists'=>$closedlists


            ]);
    }
    public function settlements()
    {

      
          $settlementslists = Settlement::orderBy('id','DESC')->with('orderref')->paginate(\Config::get('settings.pagecount'));
          return view ('admin.trade.settlements',[
            'settlementslists'=>$settlementslists


            ]);
    }


    /*public function cancelOrder($id)
    {

        $cancel=$this->cancelTradeOrder($id);
        if($cancel)
        {
        \Session::put('successmessage','Order Cancelled Successfully');
        }
        else

        {
               \Session::put('failmessage','Cancel could not be process at this time.Please Contact Admin.');
        }
        // return Redirect::to(url('/admin/tradeorder/open'));
        return back();

    }*/
    
}

?>