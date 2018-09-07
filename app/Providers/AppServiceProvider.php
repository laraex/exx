<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use App\User;
//use App\Helpers\SiteHelper;
use App\CryptoCurrency;
use App\Currencies;
use Illuminate\Support\Facades\View;
use Schema;
use App\Models\Sociallink;
use App\Models\News;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Guard $auth)
    {

        if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
            error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
            // error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
        }  // Ignores notices and reports all other kinds... and warnings

        if (Schema::hasTable('crypto_currencies'))
        {
            try{


            // need cache 5 min
            $DataBar                = CryptoCurrency::selectRaw('count(id) as CryptoCurrencies, sum(volume_24h_usd) as sumVolume_24h_usd,   sum(market_cap_usd) sumCryptoCurrencies')->first();
            $CryptoCurrencies       = $DataBar->CryptoCurrencies;
            $sumCryptoCurrencies    = number_format($DataBar->sumCryptoCurrencies,2,',','.');
            $sumVolume_24h_usd      = number_format($DataBar->sumVolume_24h_usd,2,',','.');

            $AllFiatCurrencies = Currencies::all()->where('exchange_rate','>',0);


            $BTC_price  = CryptoCurrency::whereSymbol('BTC')->orderBy('id')->first(['price_usd']);
            $ETH_price  = CryptoCurrency::whereSymbol('ETH')->orderBy('id')->first(['price_usd']);
            $BTC_price_usd = ($BTC_price ? $BTC_price->price_usd : 0 );
            $ETH_price_usd = ($ETH_price ? $ETH_price->price_usd : 0);

        }catch (QueryException $exception){
            $CryptoCurrencies       = 0;
            $sumCryptoCurrencies    = 0;
            $BTC_price_usd          = 0;
            $ETH_price_usd          = 0;
            $sumVolume_24h_usd      = 0;
            $AllFiatCurrencies      = null;

        }

        $globalData = [
            'CryptoCurrencies'      => $CryptoCurrencies,
            'sumCryptoCurrencies'   => $sumCryptoCurrencies,
            'BTC_price_usd'         => $BTC_price_usd,
            'ETC_price_usd'         => $ETH_price_usd,
            'sumVolume_24h_usd'     => $sumVolume_24h_usd,
            'AllFiatCurrencies'     => $AllFiatCurrencies,
        ];

        View::share('globalData', $globalData);
        } 

        if (Schema::hasTable('sociallinks'))
        {
            $socials = Sociallink::where('status','active')->orderBy('order','ASC')->get();
            View::share('socials',$socials);
        }

        Schema::defaultStringLength(191);
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // register the services that are only used for development
        if ($this->app->environment() == 'local') 
        {
            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
            $this->app->register('Backpack\Generators\GeneratorsServiceProvider');
        }
    }
}
