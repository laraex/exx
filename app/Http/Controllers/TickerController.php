<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Transaction;
use App\User;
use App\Models\Accountingcode;
use App\Traits\CoinProcess;


class TickerController extends Controller
{
  use CoinProcess;

    public function getpairdeatils($name)
    {

         $list='';

        if (in_array( $name, array( 'BTC', 'LTC', 'DOGE')) == TRUE)
        {
                 $id=$this->getCurrencyId($name);    

             
                $list= $this->getExternalExchangeTicker($id);
                 
        }
         return $list;
    }
    
    /**
     * Get Live Feed
     *
     * FIXME:
     * @return void
     */
    


    

}
