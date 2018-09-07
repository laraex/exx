<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        \App\Console\Commands\Exchangerates::class,      
        \App\Console\Commands\Defaultuser::class,
        \App\Console\Commands\RefreshCoins::class,
        \App\Console\Commands\CreateTestUser::class,
        \App\Console\Commands\CheckTradeOrders::class,
        \App\Console\Commands\CreateOrders::class,
        \App\Console\Commands\RedisData::class,
        \App\Console\Commands\CreateTradeUserOrders::class,
        \App\Console\Commands\CoinTransaction::class,
       \App\Console\Commands\CoinTransactionUser::class,
       \App\Console\Commands\CoinTransactionServerUser::class,
       \App\Console\Commands\CoinTransactionServer::class,
       \App\Console\Commands\GetCryptoRates::class,
       \App\Console\Commands\TokenTransaction::class,
       \App\Console\Commands\CheckBitcoindTransaction::class,
       \App\Console\Commands\CheckLitecoindTransaction::class,
       \App\Console\Commands\CheckBitcoincashdTransaction::class,
       \App\Console\Commands\NotifyRipple::class,
      \App\Console\Commands\SettlementRelease::class,
      \App\Console\Commands\CreateAdminTransaction::class,
      \App\Console\Commands\CreateCashPoint::class,
      \App\Console\Commands\CheckQtumdTransaction::class,
       \App\Console\Commands\NotifyEth::class,
       \App\Console\Commands\NotifyETHTransApprove::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('exchanger:getrates')
                 ->hourly()->withoutOverlapping();
        $schedule->command('refresh:coins')->everyFiveMinutes();
        $schedule->command('exchange:gettransactionserver')->everyMinute();
       $schedule->command('exchange:gettransactions')->everyMinute();
       $schedule->command('exchange:getsiterates')->everyMinute();
       $schedule->command('exchange:gettransactiontoken')->everyMinute();
       $schedule->command('exchange:walletnotifyripple')->everyMinute();
      $schedule->command('exchanger:checkbtctransaction')->everyMinute();
      $schedule->command('exchanger:settlementrelease')->everyMinute();
      $schedule->command('exchanger:checkqtumtransaction')->everyMinute();
      $schedule->command('exchanger:walletnotifyeth')->everyMinute();
      $schedule->command('exchanger:walletnotifyethapprove')->everyMinute();
    }
}
