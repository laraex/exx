<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptoothersiteratesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_othersite_rates', function (Blueprint $table) {
            $table->increments('id');
             $table->integer('pair_id')->unsigned();
            $table->foreign('pair_id')->references('id')->on('trade_currency_pair');
             $table->text('exchange_site')->nullable();
             $table->double('exchange_val',20,8)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crypto_othersite_rates');
    }
}
