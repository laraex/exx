<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
   /* protected $except = [
        //
    ];*/

    protected $except = [
        'myaccount/buycoin/successpaypal',
        '/chart/',
        '/bitcoind/transactionnotify/',
        '/litecoind/transactionnotify/',
        '/bitcoincashd/transactionnotify/',
        '/qtumd/transactionnotify/',
        '/blockio/transactionnotify/',
    ];
}
