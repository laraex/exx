<?php

namespace App\Http\Controllers;
use App\Http\Controllers\CryptoPayment\CryptoPaymentBase;
use App\Models\Userpayaccounts;
use App\Traits\TransactionProcess;
use App\Models\Transaction;
use Bitcoincashd;
use Exception;
use Illuminate\Http\Request;

class BitcoincashWalletNotifyController extends Controller {
	use TransactionProcess;

	public function transaction_bitcoincash(Request $request) {
		$txn_hash= $request->txid;
	
		$blockInfo = Bitcoincashd::gettransaction($txn_hash);
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

					$details1 = Userpayaccounts::where('btc_label', $account1)->whereNotNull('bch_label')->first();

					if (count($details1) > 0) {
						$balance_before = CryptoPaymentBase::crypto_getBCHWalletBalanceByAccount($account1);
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

}