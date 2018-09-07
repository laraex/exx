<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use App\Models\Giftcard;

class SellGiftCardController extends Controller
{

   
   public function __construct()
    {
        $this->middleware(['auth','admin1']);
    }


    public function index()
    {
        
        $list = Giftcard::where('active','0')->orderBy('id','ASC')->get();
        return view ('admin.giftcard.show', [
                'list' => $list
            ]);
    }
   
}

?>