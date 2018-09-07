<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradeCurrencyPair extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_currency_pair', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_currency_id')->unsigned()->nullable();
            $table->foreign('from_currency_id')->references('id')->on('currencies');
            $table->integer('to_currency_id')->unsigned()->nullable();
            $table->foreign('to_currency_id')->references('id')->on('currencies');
            $table->enum('status',['active','inactive'])->default('inactive'); 
            $table->double('min_value')->default(0);  
            $table->double('max_value')->default(0);
            $table->double('buy_fee')->default(0)->comment('%');  
            $table->double('buy_base_fee')->default(0)->comment('flat'); 
            $table->double('sell_fee')->default(0)->comment('%');  
            $table->double('sell_base_fee')->default(0)->comment('flat');  
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
        Schema::dropIfExists('trade_currency_pair');
    }
}
