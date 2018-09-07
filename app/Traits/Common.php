<?php
/**
 * Trait for processing common
 */
namespace App\Traits;

use App\Classes\block_io\BlockIo;
use App\CouponCode;
use App\CurrencyPair;
use App\Exchangerate;
use App\ExternalExchange;
use App\Http\Controllers\CryptoPayment\CryptoPaymentBase;
use App\Models\Accountingcode;
use App\Models\Currency;
use App\Models\ERC20Token;
use App\Models\Paymentgateway;
use App\Models\Usercurrencyaccount;
use App\Models\Userpayaccounts;
use App\Settings;
use App\TradeOrders;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Gegosoft\Rippled\Client;
/**
 *
 * @class trait
 * Trait for Common Processes
 */

trait Common {
	/**
	 * Getting a Value from Settings
	 *
	 * @param [type] $key
	 * @return string
	 */
	public function getSettingValue($key) {
		$value = Settings::where('key', $key)->get();
		$value = $value[0]['value'];
		return $value;
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $account_name
	 * @return void
	 */
	public function getAccountingCode($account_name) {

		$accounting_code = Accountingcode::where('accounting_code', $account_name)->get(['id'])->toArray();
		//dd($accounting_code);
		$accounting_code = $accounting_code[0]['id'];
		return $accounting_code;
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $user_id
	 * @param [type] $currency_id
	 * @return void
	 */
	public function getAccountID($user_id, $currency_id) {
		//dd($user_id.$currency_id);
		$account_id = Usercurrencyaccount::where([
			['user_id', '=', $user_id],
			['currency_id', '=', $currency_id]])
			->get(['id'])->toArray();
		$account_id = $account_id[0]['id'];
		return $account_id;

	}
	/**
	 * Undocumented function
	 *
	 * @param [type] $currency_id
	 * @return void
	 */
	public function getCurrencyname($currency_id) {
		$currencydetails = Currency::where([
			['id', '=', $currency_id],
		])->get();

		return $currencydetails[0]['name'];
	}
	public function getCurrencyId($currency_name) {
		$currencydetails = Currency::where([
			['name', '=', $currency_name],
		])->get();
		return $currencydetails[0]['id'];
	}

	public function getAccountDetails($user_id, $currency_id) {
		$account = Usercurrencyaccount::where([['user_id', '=', $user_id], ['currency_id', '=', $currency_id]])->first();
		return $account;
	}
	public function getCurrencyNameByID($currency_id) {

		$currencydetails = Currency::where([
			['id', '=', $currency_id],
		])->get();

		return $currencydetails[0]['name'];
	}
	public function getCurrencyDisplayNameByID($currency_id) {

		$currencydetails = Currency::where([
			['id', '=', $currency_id],
		])->get();

		return $currencydetails[0]['displayname'];

	}

	public function getCurrencyTokenByID($currency_id) {

		$currencydetails = Currency::where([
			['id', '=', $currency_id],
		])->get();

		return $currencydetails[0]['token'];

	}

	public static function getrate($currency_name, $type) {

		$exchangerates = Exchangerate::latest()->first();

		$exchange_rates = json_decode($exchangerates['exchange_rates'], true);

		$currencyvalue = '';
		if (count($exchange_rates) > 0) {
			foreach ($exchange_rates['rates'] as $key => $value) {
				if ($key == $currency_name) {
					$currencyvalue = $value;
				}

				if (($key == 'PrimaryCoin_buy') && ($type == 'buy') && ($currency_name == 'PrimaryCoin')) {
					$currencyvalue = $value;

				}
				if (($key == 'PrimaryCoin_sell') && ($type == 'sell') && ($currency_name == 'PrimaryCoin')) {
					$currencyvalue = $value;

				}
			}

		}

		return $currencyvalue;
	}
	public static function getBitcoinDetails($hashkey) {

		$mode = getenv('BTC_MODE');
		if ($mode == 'live') {
			$url = 'https://blockexplorer.com/api/tx/' . $hashkey;
		} else {
			$url = 'https://testnet.blockexplorer.com/api/tx/' . $hashkey;
		}

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$curl_json = curl_exec($ch);
		curl_close($ch);

		$curl_json = json_decode($curl_json, true);

		return $curl_json;
	}
	public function getPgDetails($payment_id) {
		$pg = Paymentgateway::where('id', $payment_id)->first();
		$params = json_decode($pg->params, true);
		$instructions = $pg->instructions;
		$pgInfo = [$params, $instructions];
		return $pgInfo;
	}
	public function getBitcoinUrl($hashkey) {

		$mode = getenv('BTC_MODE');
		if ($mode == 'live') {
			$url = 'https://blockexplorer.com/tx/' . $hashkey;
		} else {
			$url = 'https://testnet.blockexplorer.com/tx/' . $hashkey;
		}

		return $url;
	}

	public function getExchangeValue($currency) {

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.coinmarketcap.com/v1/ticker/bitcoin/?convert=' . $currency);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$exchange_rates = curl_exec($ch);
		$exchange_rates = json_decode($exchange_rates, true);
		curl_close($ch);

		return $exchange_rates;
	}

	public static function getCoinTxnDetails($hashkey, $currency) {

		$url = 'https://api.blockcypher.com/v1/' . $currency . '/main/txs/' . $hashkey;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$curl_json = curl_exec($ch);
		curl_close($ch);

		$curl_json = json_decode($curl_json, true);

		return $curl_json;
	}

	public function setSponsorCookie() {

		if (!Cookie::get('sponsor')) {
			$default_sponsor = $this->getSettingValue('default_sponsor');
			$root = User::where('email', $default_sponsor)->first();

			Cookie::queue('sponsor', $root->name, 48000);

		}

	}

	public function getPgDetailsByGatewayName($payment_name) {

		$pg = Paymentgateway::where('gatewayname', $payment_name)->first();
		return $pg;
	}
	public function getPgDetailsById($payment_id) {

		$pg = Paymentgateway::where('id', $payment_id)->first();
		return $pg;
	}
	public function getWalletBalance($btc_address) {

		$pg = $this->getPgDetailsByGatewayName('bitcoin_blockio');
		$user_accounts = Userpayaccounts::where([['btc_address', $btc_address], ['Paymentgateways_id', $pg->id]])->first();
		$balance = CryptoPaymentBase::crypto_getBTCWalletBalance($user_accounts);
		return $balance;
	}

	public function getLTCWalletBalance($ltc_address) {

		$pg = $this->getPgDetailsByGatewayName('ltc_blockio');
		$user_accounts = Userpayaccounts::where([['ltc_address', $ltc_address], ['Paymentgateways_id', $pg->id]])->first();
		$balance = CryptoPaymentBase::crypto_getLTCWalletBalance($user_accounts);

		return $balance;

	}

	public function getBTCWalletAdminBalance() {

		$balance = CryptoPaymentBase::crypto_getBTCWalletAdminBalance();
		return $balance;
	}

	public function getLTCWalletAdminBalance() {
		$balance = CryptoPaymentBase::crypto_getLTCWalletAdminBalance();

		return $balance;

	}
	public function getETHWalletBalance($address) {
		$balance = CryptoPaymentBase::crypto_getETHWalletBalance($address);

		return $balance;

	}
	public function getETHWalletAdminBalance() {

		$balance = CryptoPaymentBase::crypto_getETHWalletAdminBalance();
		return $balance;
	}
	public function getBCHWalletBalance($address) {
		$balance = CryptoPaymentBase::crypto_getBCHWalletBalance($address);

		return $balance;

	}
	public function getBCHWalletAdminBalance() {

		$balance = CryptoPaymentBase::crypto_getBCHWalletAdminBalance();
		return $balance;
	}

	public function getDOGEWalletBalance($doge_address) {
		$pg = $this->getPgDetailsByGatewayName('dogecoin_blockio');
		$params = json_decode($pg->params, true);
		$api_key = $params['api_key'];
		$pin = $params['pin'];
		$version = $params['version']; // API version
		$block_io = new BlockIo($api_key, $pin, $version);
		$available_balance = 0;
		try
		{
			$balance = $block_io->get_address_balance(array('addresses' => $doge_address));
			$available_balance = $balance->data->available_balance;
		} finally {
			return $available_balance;
		}
	}
	public function randomString() {
		$length = 10;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	public function getExchangeTransactionID() {

		$transaction_id = $this->randomString();
		$transaction_id_exists = ExternalExchange::where('transaction_id', $transaction_id)->exists();
		if ($transaction_id_exists) {

			$this->getExchangeTransactionID();
		}
		return $transaction_id;

	}
	public function getCurrencyDetailsByName($currency_name) {
		$currencydetails = Currency::where([
			['name', '=', $currency_name],
		])->first();
		return $currencydetails;
	}
	public function getExternalExchange($amount, $tocurrency_name, $fromcurrency_name, $type, $variant) {

		// $exchangerate_per=$this->getexchangerate(1, $pair_details->tocurrency->name,$pair_details->fromcurrency->name ,'buy');
		$exchangerate_per = $this->getexchangerate($amount, $tocurrency_name, $fromcurrency_name, $type);

		$exchangerate_per = sprintf("%.8f", $exchangerate_per);

		$variant_total = $exchangerate_per * ($variant / 100);

		$total_amount = $exchangerate_per + $variant_total;

		return $total_amount;
	}

	public function getCurrencyDetails($currency_id) {
		$currencydetails = Currency::where([
			['id', '=', $currency_id],
		])->first();

		return $currencydetails;
	}

	public function getTxn($mode, $txn_id) {
		return 'https://chain.so/tx/' . $mode . '/' . $txn_id;
	}

	public function getExternalExchangeTicker($currency_id) {
		$tocurrency = CurrencyPair::where([['status', 'active'], ['from_currency_id', $currency_id]])->groupBy('to_currency_id')->get();
		$array = array();
		$i = 0;

		foreach ($tocurrency as $key => $value) {

			$amount = $this->getExternalExchange(1, $value->tocurrency->name, $value->fromcurrency->name, 'buy', $value->exchange_rate_variant);

			$final_amount = number_format((float) $amount, $value->fromcurrency->decimal);
			$array[$i]['from_currency_token'] = $value->fromcurrency->token;
			$array[$i]['amount'] = $final_amount;
			$array[$i]['to_currency_token'] = $value->tocurrency->symbol;

			$exchangerates = Exchangerate::orderby('id', 'desc')->take(2)->get();
			$final_total = 0;
			$final_total_per = 0;
			if (count($exchangerates) == 2) {

				$prev_amount = $this->getExternalExchangeRates(1, $value->tocurrency->name, $value->fromcurrency->name, 'buy', $value->exchange_rate_variant, $exchangerates[1]);
				$final_prev_amount = number_format((float) $prev_amount, 5);
				$total = $amount - $prev_amount;
				$final_total = sprintf("%.2f", $total);
				// $final_total=$finaltotal*100;
				$final_total_per = ($total / $prev_amount) * 100;
				$final_total_per = sprintf("%.2f", $final_total_per);
			}
			$array[$i]['final_total'] = $final_total;
			$array[$i]['final_total_per'] = $final_total_per;
			$i++;
		}
		return $array;
	}

	public function getexchangerate($amount, $from_currency_name, $to_currency_name, $type) {
		//Payment Gateway -$from_currency_name

		$exchangerates = Exchangerate::latest()->first();

		$exchange_rates = json_decode($exchangerates['exchange_rates'], true);
		$from_currencyvalue = 0;
		$finalcurrencyvalue = '';
		if (count($exchange_rates) > 0) {
			foreach ($exchange_rates['rates'] as $key => $value) {
				if ($key == $from_currency_name) {
					$from_currencyvalue = $value;
				}

				if (($key == 'PrimaryCoin_buy') && ($type == 'buy') && ($from_currency_name == 'PrimaryCoin')) {
					$from_currencyvalue = $value;
				}

				if (($key == 'PrimaryCoin_sell') && ($type == 'sell') && ($from_currency_name == 'PrimaryCoin')) {
					$from_currencyvalue = $value;
				}
			}

			//dd($from_currencyvalue);

			foreach ($exchange_rates['rates'] as $key => $value) {
				if ($key == $to_currency_name) {
					$currencyvalue = $value;
				}

				if (($key == 'PrimaryCoin_buy') && ($type == 'buy') && ($to_currency_name == 'PrimaryCoin')) {
					$currencyvalue = $value;
				}

				if (($key == 'PrimaryCoin_sell') && ($type == 'sell') && ($to_currency_name == 'PrimaryCoin')) {
					$currencyvalue = $value;
				}
			}

			//dd($currencyvalue);
			if ($to_currency_name != $from_currency_name) {
				if ($type == 'buy') {
					// dd("BB".$amount.$from_currencyvalue.$currencyvalue);
					$finalcurrencyvalue = $amount * ($from_currencyvalue / $currencyvalue);
				}

				if ($type == 'sell') {
					$finalcurrencyvalue = $amount * ($currencyvalue / $from_currencyvalue);
				}
			}
		}

		// dd("JJ");
		return $finalcurrencyvalue;
	}

	public function getExternalExchangeRates($amount, $tocurrency_name, $fromcurrency_name, $type, $variant, $exchangerates) {
		$exchangerate_per = $this->getexchangerates($amount, $tocurrency_name, $fromcurrency_name, $type, $exchangerates);

		$exchangerate_per = sprintf("%.8f", $exchangerate_per);

		$variant_total = $exchangerate_per * ($variant / 100);

		$total_amount = $exchangerate_per + $variant_total;

		return $total_amount;
	}

	public function getCouponCode() {
		$coupon_code = $this->randomString();
		$coupon_code_exists = CouponCode::where('code', $coupon_code)->exists();
		if ($coupon_code_exists) {
			$this->getCouponCode();
		}
		return $coupon_code;
	}
	public function getOrders($type, $fromcurrency_id, $tocurrency_id) {

		$past_24hrs = Carbon::now()
			->subHours(24)
			->format("Y-m-d H:i:s");

		$orderdata = TradeOrders::where([['to_coin_id', $fromcurrency_id], ['from_coin_id', $tocurrency_id], ['type', 'order']])->with('buyorder', 'sellorder')->orderBy('created_at', 'DESC')->first();

		$lastday = TradeOrders::where([['to_coin_id', $fromcurrency_id], ['from_coin_id', $tocurrency_id], ['type', 'order']])->where('created_at', '>=', Carbon::now()->subDays(1))->with('buyorder', 'sellorder')->first();

		$total_tran = TradeOrders::where([['to_coin_id', $tocurrency_id], ['from_coin_id', $fromcurrency_id], ['type', 'buy'], ['status', 'complete']])->where('created_at', '>=', $past_24hrs)->sum('amount');

		if ($orderdata != null) {
			$last_order_amt = $orderdata->buyorder->amount;
		} else {
			$last_order_amt = 0;
		}

		if ($lastday != null) {
			$last_day_amt = $lastday->buyorder->amount;
		} else {
			$last_day_amt = 0;
		}

		if ($last_order_amt != '' && $last_day_amt != '') {

			$H24_diff_amt = $last_order_amt - $last_day_amt;
		} else {
			$H24_diff_amt = 0;
		}

		if ($last_day_amt < $last_order_amt) {

			$updown_status = 1;

		} else {
			$updown_status = 0;
		}

		if ($last_order_amt != '') {

			$per = ($H24_diff_amt / $last_order_amt * 100);
		} else {
			$per = 0;
		}

		if ($type == 1) {
			$orders = $last_order_amt;
		} else if ($type == 2) {
			$orders = $per;
		} else if ($type == 3) {
			$orders = $total_tran;
		}

		return $orders;

	}

	public function getcurrencyBalance($currency_name, $currency_id, $user_id, $type) {

		$balance = 0;
		$address = '';
		$user = User::where('id', $user_id)->with('userprofile')->first();

		$userpay = Userpayaccounts::where([['currency_id', '=', $currency_id], ['user_id', '=', $user_id]])->first();
		$balance = 0;

		if ($currency_name == 'BTC') {
			if ($userpay != null) {
				$address = $userpay->btc_address;
				$balance = $this->getWalletBalance($address);
			}

		} else if ($currency_name == 'LTC') {

			if ($userpay != null) {
				//echo $user_id.$address;
				$address = $userpay->ltc_address;
				$balance = $this->getLTCWalletBalance($address);
			}

		} else if ($currency_name == 'ETH') {

			if ($userpay != null) {
				$address = $userpay->eth_address;
				$balance = $this->getETHWalletBalance($address);
			}

		} else if ($currency_name == 'BCH') {
			if ($userpay != null) {
				$address = $userpay->bch_address;
				$balance = $this->getBCHWalletBalance($address);
			}

		} else if ($currency_name == 'KRW') {
			//dd($currency_id);
			$balance = $this->getUserCurrencyBalance($user, $currency_id);
			$address = 'KRW';

			//$pgs = Paymentgateway::where('currency_id', $currency->id)->first();
		} else if ($currency_name == 'USD') {

			$balance = $this->getUserCurrencyBalance($user, $currency_id);
			$address = 'USD';
		} else {
			$balance = 0;
			$address = '';
		}
		if ($type == 'balance') {
			return $balance;
		} else {
			return $address;
		}

	}
	public function getResponse($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$curl_json = curl_exec($ch);
		curl_close($ch);
		$curl_json = json_decode($curl_json, true);
		return $curl_json;
	}
	public function getQTUMWalletBalance($address) {
		$balance = CryptoPaymentBase::crypto_getQTUMWalletBalance($address);

		return $balance;

	}
	public function getTokenDetails($token_symbol) {
		$tokendetails = ERC20Token::where([
			['token_symbol', '=', $token_symbol],
		])->first();

		return $tokendetails;
	}
	public function getETHTokenBalance($token_symbol, $address) {
		$balance = 0;
		try {
			$pg = $this->getPgDetailsByGatewayName('eth');

			$details = $this->getTokenDetails($token_symbol);
			$mode = $details->mode;

			$apikey = getenv('ETH_ERC20_TOKEN_APIKEY');
			if ($mode == 'live') {
				$url = 'http://api.etherscan.io/';
			} else {
				$url = 'http://api-rinkeby.etherscan.io/';
			}
			$url .= 'api?module=account&action=tokenbalance&contractaddress=' . $details->token_contract_address . '&address=' . $address . '&tag=latest&apikey=' . $apikey;

			$bal = $this->getResponse($url);
			if (count($bal) > 0) {
				if ($bal['status'] == "1") {
					$balance = $bal['result'] / (pow(10, $details->decimal));

				}
			}
		} finally {
			return $balance;
		}
	}

	public function getBTCCoinTxn($mode, $txid) {
		//   $mode = env('BTC_MODE');

		if ($mode == 'live') {
			return 'https://blockexplorer.com/tx/' . $txid;
		} else {
			return 'https://testnet.blockexplorer.com/tx/' . $txid;
		}
	}

	//sowmi
	public function getLTCCoinTxn($mode, $txid) {
		if ($mode == 'live') {
			$txn_mode = "LTC";

			return 'https://chain.so/tx/' . $txn_mode . '/' . $txid;
		} else {
			$txn_mode = "LTCTEST";

			return 'https://chain.so/tx/' . $txn_mode . '/' . $txid;
		}
	}
	public function getBCHUrl($hashkey) {
		$mode = getenv('BCH_MODE');

		if ($mode == 'live') {
			$url = 'https://www.blocktrail.com/BCC/tx/' . $hashkey;
		} else {
			$url = 'https://www.blocktrail.com/tBCC/tx/' . $hashkey;

		}
		return $url;
	}
	public function getETHTxnUrl($mode, $txid) {
		$url = '';
		if ($mode == 'live') {
			$url = 'https://etherscan.io/tx/' . $txid;
		} else {
			if (getenv('ETH_TEST_NETWORK') == 'rinkeby') {
				$url = 'https://rinkeby.etherscan.io/tx/' . $txid;
			}
			if (getenv('ETH_TEST_NETWORK') == 'ropsten') {
				$url = 'https://ropsten.etherscan.io/tx/' . $txid;
			}

		}
		return $url;
	}
	public function getQTUMCoinTxn($mode, $txid) {
		//   $mode = env('BTC_MODE');

		if ($mode == 'live') {
			return 'https://blockexplorer.com/tx/' . $txid;
		} else {
			return 'https://testnet.blockexplorer.com/tx/' . $txid;
		}
	}
	public function getPostResponse($url, $data) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$curl_json = curl_exec($ch);
		curl_close($ch);
		$curl_json = json_decode($curl_json, true);
		return $curl_json;
    }
    public function getXRPWalletBalance($address)
    {
        $client = new Client(getenv('XRP_URL'));

        $balance = 0;

        $response = $client->send('account_info', [
            'account' => $address
        ]);
    
    // Set balance if successful.
        if ($response->isSuccess()) {
            $data = $response->getResult();
            $balance = $data['account_data']['Balance'];

            return $balance * 0.0001 / 100;

        }else{
            return $balance;
        }
	}
	
    public function decodeBase58($input)
    {
        $alphabet = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";

        $out = array_fill(0, 25, 0);
        for ($i = 0; $i < strlen($input); $i++) {
            if (($p = strpos($alphabet, $input[$i])) === false) {
				throw new \Exception("invalid character found");
            }
            $c = $p;
            for ($j = 25; $j--;) {
                $c += (int) (58 * $out[$j]);
                $out[$j] = (int) ($c % 256);
                $c /= 256;
                $c = (int) $c;
            }
            if ($c != 0) {
                throw new \Exception("address too long");
            }
        }

        $result = "";
        foreach ($out as $val) {
            $result .= chr($val);
        }

        return $result;
    }

}
