<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\Fundtransfer;


class FundtransferController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['auth','admin1']);
    }

    public function index()
    {
        $fundtransfer = Fundtransfer::with('fundtransfer_to_id', 'fundtransfer_from_id', 'transaction')->orderBy('id', 'DESC')->get();

        //dd($fundtransfer);

        //dd($getcommissionlists);
        return view('admin.fundtransfer', [
        	'fundtransfer' => $fundtransfer,
        	]);
    }
}
