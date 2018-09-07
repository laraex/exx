<?php

namespace App\Traits;

use App\Models\Transaction;

trait TransactionProcess {

	public function makeTransaction($account_id, $amount, $type, $status, $action, $accounting_code, $comment, $request_json, $response_json, $entity_id, $entity_name) {

		$transaction = new Transaction;
		$transaction->account_id = $account_id;
		$transaction->amount = $amount;
		$transaction->type = $type;
		$transaction->status = $status;
		$transaction->action = $action;
		$transaction->accounting_code_id = $accounting_code;
		$transaction->comment = $comment;
		$transaction->request = json_encode($request_json);
		$transaction->response = json_encode($response_json);
		$transaction->entity_id = $entity_id;
		$transaction->entity_name = $entity_name;
		$transaction->save();
		return $transaction;
	}

	public function createTransaction($user_id, $currency_id, $amount, $type, $status, $action, $accounting_code, $comment, $request_json, $response_json, $entity_id, $entity_name, $balance_before, $balance_after,$blockchain_transaction_id,$blockchain_data, $array) {

		$transaction = new Transaction;
		$transaction->user_id = $user_id;
		$transaction->currency_id = $currency_id;
		$transaction->amount = $amount;
		$transaction->type = $type;
		$transaction->status = $status;
		$transaction->action = $action;
        if($accounting_code!='NULL')
        {
		      $transaction->accounting_code_id = $accounting_code;
        }
		$transaction->comment = $comment;
		$transaction->request = $request_json;
		$transaction->response = $response_json;
		$transaction->entity_id = $entity_id;
		$transaction->entity_name = $entity_name;
        $transaction->blockchain_transaction_id = $blockchain_transaction_id;        
        $transaction->blockchain_data = $blockchain_data;        
        $transaction->balance_before = $balance_before;        
        $transaction->balance_after = $balance_after; 
		$transaction->save();
		return $transaction;
	}

}