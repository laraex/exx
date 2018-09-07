<?php

return [

 

      
    'coin' => [
                      'btc' => [
                                 'driver'=> env('BITCOIN_DRIVER', ''),//Driver [blockio,bitcoind]
                                   'blockio'=>[
                                   'address' => env('BLOCKIO_BTC_ADDRESS', ''),
                                   'apikey' => env('BLOCKIO_BTC_APIKEY', ''),
                                   'version'   => env('BLOCKIO_VERSION', ''),
                                   'pin'   => env('BLOCKIO_SECRETPIN', ''),
                               
                              
                                  ],
                                  'bitcoind'=>[
                                      'min_confirmation'   => env('BITCOIND_BITCOIN_MIN_CONF', ''),
                                      'address'   => env('BITCOIND_BITCOIN_ADDRESS', ''),
                                  ],
                                ],

                      'ltc' => [
                                  'driver'=>env('LITECOIN_DRIVER', ''),//Driver [blockio,litecoind]
                                   'blockio'=>[
                                   'address' => env('BLOCKIO_LTC_ADDRESS', ''),
                                   'apikey'   => env('BLOCKIO_LTC_APIKEY', ''),
                                   'version'   => env('BLOCKIO_VERSION', ''),
                                   'pin'   => env('BLOCKIO_SECRETPIN', ''),
                                 ],
                                   'litecoind'=>[
                                      'min_confirmation'   => env('LITECOIND_LITECOIN_MIN_CONF', ''),
                                      'address'   => env('LITECOIND_LITECOIN_ADDRESS', ''),
                                  ],
                                ],
                      'eth'=>[
                        'driver'=>env('ETHEREUM_DRIVER', ''),//Driver [eth]
                        'ethereum'=>[
                        'address'=>env('ETHEREUM_ADDRESS', ''),
                        'passphrase'=>env('ETHEREUM_PASS_PHRASE', ''),
                        ],
                        ],

                       'bch'=>[
                        'driver'=>env('BCH_DRIVER', ''),//Driver [bch]
                        'bitcoincash'=>[
                        'address'=>env('BCH_ADDRESS', ''),
                        'min_confirmation'   => env('BCH_MIN_CONF', ''),

                        ],

                      ],
                      'qtum' => [
                        'driver'=> env('QTUM_DRIVER', ''),
                         'qtumd'=>[
                             'min_confirmation'   => env('QTUMD_QTUM_MIN_CONF', ''),
                             'address'   => env('QTUMD_QTUM_ADDRESS', ''),
                         ],
                       ],
            


    ],

];
