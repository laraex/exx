<?php

       Route::get('/translations', function () {

        $array = array(
                'balance' => trans('forms.balance'), 
                'amount' => trans('forms.volume_lbl'),
                'price' => trans('forms.price_lbl'), 
                'sell' => trans('forms.sell_btn'),
                'buy' => trans('forms.buy_btn'),
                'fee' => trans('forms.fee'),
                'payamount' => trans('forms.payamount'),
                 'tradebuy' => trans('forms.trade_buy_title'),
                 'tradesell' => trans('forms.trade_sell_title'),
                  'tradeorder' => trans('forms.trade_order_title'),
                'investment_amount' => trans('welcome.investment_amount'),
                'plan_type' => trans('welcome.plan_type'),
                'investment_duration' => trans('welcome.investment_duration'),
                'total_interest' => trans('welcome.total_interest'),
                'total_return' => trans('welcome.total_return'),
                'return_on_investment' => trans('welcome.return_on_investment'),
                'currency' => \Config::get('settings.currency'),
                'calculator_slider_value' => \Config::get('settings.calculator_slider_value'),
                "total_volume"=>trans('forms.total_volume_lbl'),
                 "total_amount"=>trans('forms.total_amount'),
                 "volume"=>trans('forms.volume_lbl'),
                 "price_per"=>trans('forms.price_per'),
                 "date"=>trans('forms.date'),
                 "h24_volume"=>trans('forms.h24_volume'),
                  "reset"=>trans('forms.reset'),
                 "buy"=>trans('forms.buy'),
                 "sell"=>trans('forms.sell'),
                 "trans_history"=>trans('forms.trans_history'),
                 "signup"=>trans('menu.signup'),
                 "login"=>trans('forms.login'),
                  "high"=>trans('forms.high'),
                 "low"=>trans('forms.low'),
                  "day_before"=>trans('forms.day_before'),
                 "h24_amount"=>trans('forms.h24_amount'),

                  "coinname"=>trans('forms.coinname'),
                  "holding"=>trans('forms.holding'),
                   "quantity"=>trans('forms.quantity'),
                  
                 "option"=>trans('forms.option'),
                  "total_assets"=>trans('forms.total_assets'),
                   "address"=>trans('wallet.address'),
                 "send_amount"=>trans('wallet.send_amount'),
                 "deposit"=>trans('wallet.deposit'),
               "charge"=>trans('wallet.charge'),
                "wallet"=>trans('wallet.wallet'),
               "withdrawal"=>trans('wallet.withdrawal'),
                "balance"=>trans('wallet.balance'),
                 "send"=>trans('wallet.send'),
                 "receive"=>trans('wallet.receive'),
                "amount_to_be_deposited"=>trans('forms.amount_to_be_deposited'),
                "transaction_id"=>trans('forms.transaction_id'),
                 "bank_name_lbl"=>trans('forms.bank_name_lbl'),
                 "swift_code_lbl"=>trans('forms.swift_code_lbl'),
                 "account_name_lbl"=>trans('forms.account_name_lbl'),
                 "account_no_lbl"=>trans('forms.account_no_lbl'),
                 "submit_complete_btn"=>trans('forms.submit_complete_btn'),
                 "backtomywallet"=>trans('forms.backtomywallet'),
                 "printinvoice"=>trans('forms.printinvoice'),
                 "submit"=>trans('forms.submit'),
                  "addfund"=>trans('forms.addfund'),
                  "amount_lbl"=>trans('forms.amount_lbl'),
                  "transaction_lbl"=>trans('forms.transaction_lbl'),
                   "select_payment"=>trans('wallet.select_payment'),
                   "select"=>trans('wallet.select'),
                    "time"=>trans('wallet.time'),
                    "contractamount"=>trans('wallet.contractamount'),
                    "date"=>trans('wallet.date'),
                    "closeprice"=>trans('wallet.closeprice'),
                    "daybefore"=>trans('wallet.daybefore'),
                    "fastening"=>trans('wallet.fastening'),
                    "price"=>trans('wallet.price'),
                    "fromaddress"=>trans('wallet.fromaddress'),
                    "toaddress"=>trans('wallet.toaddress'),
                    "transid"=>trans('wallet.transid'),
                    "amount"=>trans('wallet.amount'),
                    "transhis"=>trans('wallet.transhis'),
                    "signup"=>trans('menu.signup'),
                    "login"=>trans('menu.login'),
                    "volumeerrmsg"=>trans('wallet.volume_errmsg'),
                    "amounterrmsg"=>trans('wallet.amount_errmsg'),
                    "sellvolumeerrmsg"=>trans('wallet.sellvolume_errmsg'),
                    "sellamounterrmsg"=>trans('wallet.sellamount_errmsg'),
                    "conculsion"=>trans('wallet.conculsion'),
                    "glance"=>trans('wallet.glance'),
                    "coininfor"=>trans('wallet.coininfor'),
                    "addbankacc"=>trans('wallet.addbankacc'),
                    "bankname"=>trans('wallet.bankname'),
                    "swiftcode"=>trans('wallet.swiftcode'),
                    "accountno"=>trans('wallet.accountno'),
                    "accountname"=>trans('wallet.accountname'),
                    "accountaddr"=>trans('wallet.accountaddr'),
                    "addbank"=>trans('wallet.addbank'),
                     "viewacc"=>trans('wallet.viewacc'),
                     "withdrawinfor"=>trans('wallet.withdrawinfor'),
                    "transpasserr"=>trans('wallet.transpasserr'),
                    "selectpayerr"=>trans('wallet.selectpayerr'),
                     "addresserr"=>trans('wallet.addresserr'),
                      "banknameerr"=>trans('wallet.banknameerr'),
                     "swiftcodeerr"=>trans('wallet.swiftcodeerr'),
                    "accountnoerr"=>trans('wallet.accountnoerr'),
                    "accountnameerr"=>trans('wallet.accountnameerr'),
                     "accountaddrerr"=>trans('wallet.accountaddrerr'),
                     "totalremain"=>trans('wallet.totalremain'),
                   "volume24h"=>trans('wallet.volume24h'),
                     "amount24h"=>trans('wallet.amount24h'),
                     "qty"=>trans('wallet.qty'),
                      "lasttradeprice"=>trans('wallet.lasttradeprice'),
                      "totalvol"=>trans('wallet.totalvol'),
                      "totalamt"=>trans('wallet.totalamt'),
                      "action"=>trans('wallet.action'),
                      "cancel"=>trans('wallet.cancel'),
                      "norecords"=>trans('wallet.norecords'),
                      "XRPminireserve"=>trans('wallet.XRPminireserve'),
                       "insufficentbal"=>trans('wallet.insufficentbal'),
                      "viewtrans"=>trans('wallet.viewtrans'),
                       "create"=>trans('wallet.create'),
                      "wallet"=>trans('wallet.wallet'),
                      "servererror"=>trans('wallet.servererror'),
                      "tryagain"=>trans('wallet.tryagain'),
                      "viewall"=>trans('wallet.viewall'),
                      "bankdetails"=>trans('wallet.bankdetails'),
                      "delete"=>trans('wallet.delete'),
                      
                      
                      
                );
 
        return json_encode($array);
    });

?>