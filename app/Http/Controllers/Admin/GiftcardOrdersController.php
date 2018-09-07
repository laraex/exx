<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\GiftcardOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Traits\GiftCardProcess;

class GiftcardOrdersController extends Controller
{
    use GiftCardProcess;

    public function __construct()
    {
        $this->middleware(['auth','admin1']);
    }

    public function index()
    {
    	$giftcardOrders = GiftcardOrder::with('giftcard', 'user')->get();
    	//dd($giftcardOrders);
        return view('admin.giftcardorders.show', [
        		'giftcardOrders' => $giftcardOrders,
        ]);
    }

    public function giftCardOrdersConfirm($id)
    {
    	$giftcardconfirm = GiftcardOrder::where('id', $id)->with('giftcard', 'user')->first();
    	return view('admin.giftcardorders.complete', [
    			'giftcardconfirm' => $giftcardconfirm,
    	]);
    }

    public function addToWallet($id)
    {
        $this->addToWalletBuyGiftCard($id);
 
    	return Redirect::to('/admin/giftcardorders');
    }

    public function addToWalletComment(Request $request, $id)
    {
    	//dd($request);
    	$giftOrder = GiftcardOrder::where([['id', $id],['status','approve']])->first(); 

        $destinationPath = "uploads/giftcardorders";
        $file = $request->giftcardorder;
        if($file != '')
        {
        	$filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
	        $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
	        $filerename = $filename.'_'.time().'.'.$extension;
	        $file->move($destinationPath, $filerename);         
	        $pathname = $destinationPath.'/'.$filerename; 
        }
        else
        {
        	$pathname = '';
        }             
        
        if(count($giftOrder)>0)
        {
            $update = [
                'image'=>$pathname,                                
                'status'=>'complete',                                
                'comments'=>$request->comment,                         
            ];
        }
        GiftcardOrder::where('id', $id)->update($update);
    	return Redirect::to('/admin/giftcardorders');
    }
}