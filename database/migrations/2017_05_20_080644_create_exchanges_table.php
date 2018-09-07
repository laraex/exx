<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchanges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('transaction_id')->unsigned();
            // $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->double('from_amount');
            $table->integer('from_currency_account')->unsigned();
            $table->foreign('from_currency_account')->references('id')->on('usercurrencyaccounts');
            $table->double('to_amount');       
            $table->integer('to_currency_account')->unsigned();
            $table->foreign('to_currency_account')->references('id')->on('usercurrencyaccounts');            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchanges');
    }
}
