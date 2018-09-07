<?php

namespace App\Traits;

trait PaymentProcess {
 
    public function paypalProcess($request)
    {

            $tx=$request->request->get('tx');
            $st=$request->request->get('st');
            $amt=$request->request->get('amt');
            $cc=$request->request->get('cc');
            $item_name=$request->request->get('item_name');

                                $array = array();
                                $array=[
                                'tx'=>$tx,
                                'st'=>$st,
                                'amt'=>$amt,
                                'cc'=>$cc,
                                'item_name'=>$item_name,
                                

                                ];
            $response=json_encode($array); 
         
        return $response;
    }

    public function skrillProcess($request)
    {

                               $array = array();
                                $array=[
                                'tx_id'=>$request->transaction_id,
                                'msid'=>$request->msid, 
                                ];
            $response=json_encode($array); 
         
        return $response;
    }

    public function netellerProcess($request,$params)
    {

      if ($params['paymentmode'] == 'test')
        {
            $paymenturl = 'https://test.api.neteller.com/netdirect';
        }
        else
        {
            $paymenturl = 'https://api.neteller.com/netdirect';
        }

        // open curl connection
        $ch = curl_init($paymenturl);

        // get the vars from POST request and add them as POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'version' => $request->version,
            'amount' => urlencode($request->amount),
            'currency' => $request->currency,
            'net_account' => urlencode($request->net_account),
            'secure_id' => urlencode($request->secure_id),
            'merchant_id' => urlencode($request->merchant_id),
            'merch_key' => urlencode($request->merch_key),
            'merch_transid' => urlencode($request->merch_transid),
            'language_code' => $request->language_code,
            'merch_name' => urlencode($request->merch_name),
            'merch_account' => urlencode($request->merch_account),
            'custom_1' => urlencode($request->custom_1),
            'custom_2' => urlencode($request->custom_1),
            'custom_3' => urlencode($request->custom_1), 
            'button' => 'Make Transfer'
        ]));

        // set other curl options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        // execute post
        $output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $error = '';
        $response = simplexml_load_string($output);
       // $curlerror = curl_error($ch); 
        // dd($output->error_message);
        // close curl connection
        curl_close($ch); 

        return $response;
         

    }

   
 }