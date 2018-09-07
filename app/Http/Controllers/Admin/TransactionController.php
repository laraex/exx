<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Exchange;
use App\ExternalExchange;
use App\Coinorder;
use App\Transfer;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_fiat()
    {
        //dd('sowmi');
         $transactions = Exchange::with('exchange_from_account','exchange_to_account')->orderBy('id','DESC')->paginate(10);
        // dd($transactions);
         return view('admin.transaction.show_fiat',[
             'transactions'=>$transactions,
        ]);
    }

     public function index_crypto()
    {
           $transactions = ExternalExchange::orderBy('id','DESC')->paginate(10);


        return view('admin.transaction.show_crypto',[
             'transactions'=>$transactions,
        ]);
    }


     public function index_buycoin()
    {
        $transactions = Coinorder::where('type','buy')->with('tocurrency','fromcurrency')->orderBy('id','DESC')->paginate(10);


        return view('admin.transaction.show_buycoin',[
             'transactions'=>$transactions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function index_sellcoin()
    {
        $transactions = Transfer::with('currency')->orderBy('id','DESC')->paginate(10);

        return view('admin.transaction.show_sellcoin',[
             'transactions'=>$transactions,
        ]);
    }
}
