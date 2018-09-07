<?php

namespace App\Http\Controllers;
use App\Http\Controllers\CryptoPayment\CryptoPaymentBase;
use App\Models\Userpayaccounts;
use App\Traits\TransactionProcess;
use App\Models\Transaction;
use Bitcoind;
use Exception;
use Illuminate\Http\Request;
use App\Tag;
class BitcoindWalletNotifyController extends Controller {
	use TransactionProcess;

	public function transaction_bitcoin(Request $request) {
		$txn_hash= $request->txid;

		$blockInfo = Bitcoind::gettransaction($txn_hash);
		$response = response()->json($blockInfo->get());
		$array = [];
		$category1 = '';
		$account1 = '';
		$amount1 = '';

		$category2 = '';
		$account2 = '';
		$amount2 = '';
		$address2 = '';
//dd($response->original);
		try {
			if (count($response->original) > 0) {

				if (count($response->original['details']) > 0) {
					$category1 = $response->original['details'][0]['category'];
					$account1 = $response->original['details'][0]['account'];
					$amount1 = abs($response->original['details'][0]['amount']);

					$balance_before = 0;
					$balance_after = 0;

					if ($category1 == 'receive') {
						$type = 'credit';

					}
					if ($category1 == 'send') {
						$type = 'debit';
					}

					$details1 = Userpayaccounts::where('btc_label', $account1)->whereNotNull('btc_label')->first();

					if (count($details1) > 0) {
						$balance_before = CryptoPaymentBase::crypto_getBTCWalletBalanceByAccount($account1);
						$balance_after = $balance_before;

						if (!Transaction::where([['blockchain_transaction_id', $txn_hash], ['user_id', $details1->user_id]])->exists()) {

               $transaction=$this->createTransaction($details1->user_id,$details1->currency_id,$amount1,$type,"pending","cashpoint","NULL",'Notify',"NULL","NULL","NULL","NULL",0,0,$txn_hash,json_encode($response->original),$array);

							

						}
					}

					if (count($response->original['details']) > 1) {

						$category2 = $response->original['details'][1]['category'];
						$account2 = $response->original['details'][1]['account'];
						$amount2 = abs($response->original['details'][1]['amount']);
						$address2 = $response->original['details'][1]['address'];

						if ($category2 == 'receive') {
							$type = 'credit';

						}
						if ($category2 == 'send') {
							$type = 'debit';
						}

						$details2 = Userpayaccounts::where('btc_address', $address2)->first();
						if (count($details2) > 0) {
							$balance_before = 0;
							$balance_before = 0;

							if (!Transaction::where([['blockchain_transaction_id', $txn_hash], ['user_id', $details2->user_id]])->exists()) {

                   $transaction=$this->createTransaction($details2->user_id,$details2->currency_id,$amount2,$type,"pending","cashpoint","NULL",'Notify',"NULL","NULL","NULL","NULL",0,0,$txn_hash,json_encode($response->original), $array);

							}
						}

					}
				}

			}
		} catch (Exception $e) {
			//dd($e->getMessage());

		}


	}

	public function transaction_blockio(Request $request) {
	
		try {
			$array=[];
			

	// 				$balance_before = 0;
	// 				$balance_after = 0;
 //                      $array='';
					
	// 					$type = 'debit';
	// 					$txn_hash='fgfdgf';

	// 					$response->original=[];

 //               $transaction=$this->createTransaction('2','1',10,$type,"pending","cashpoint","NULL",'dsadsad','NULL',"Null","8","App\User",0,0,$txn_hash,json_encode($response->original),$array);

 // //              public function createTransaction($user_id, $currency_id, $amount, $type, $status, $action, $accounting_code, $comment, $request_json, $response_json, $entity_id, $entity_name, $balance_before, $balance_after,$blockchain_transaction_id,$blockchain_data, $array) {

	// 	$transaction = new Transaction;
	// 	$transaction->user_id = '12';
	// 	$transaction->currency_id = '1';
	// 	$transaction->account_id = 'NULL';
	// 	$transaction->amount = '10';
	// 	$transaction->type = $type;
	// 	$transaction->status ='pending';
	// 	$transaction->action ='cashpoint';
        
	// 	$transaction->comment ='fdfs';
	// 	//$transaction->request ='NULL';
	// 	//$transaction->response ='NULL';
	// 	$transaction->entity_id ='3';
	// 	$transaction->entity_name ="App\User";
 //       // $transaction->blockchain_transaction_id = '';        
 //       // $transaction->blockchain_data ='';        
 //        $transaction->balance_before ='0.000';        
 //        $transaction->balance_after ='0.000'; 
	// 	$transaction->save();
	// 	return $transaction;
	// }

			/*$tag=new Tag;
			$tag->name="Test";
			$tag->save();*/


			  //$transaction=$this->createTransaction(8,1,0,'credit',"pending","cashpoint","NULL",'Notify',"NULL","NULL","NULL","NULL",0,0,"NULL",$request->getContent(), $array);

			  $s=json_decode($request->getContent());

           //dd($s->data->balance_change);

           $userpay = Userpayaccounts::where('btc_address', $s->data->address)->first();
           //dd($userpay);

           $user_id=$userpay->user_id;
           $currency_id=$userpay->currency_id;
           $amount=$s->data->balance_change;
           if($amount>0){
           	$type="credit";

           }else{
               $type="debit";
               $amount=abs($amount);
           }

      $transaction=$this->createTransaction($user_id,$currency_id,$amount,$type,"pending","cashpoint","NULL",'Notify',"NULL","NULL","NULL","NULL",0,0,"NULL",$request->getContent(), $array);


			
		} catch (Exception $e) {
			dd($e->getMessage());

		}


	}

}