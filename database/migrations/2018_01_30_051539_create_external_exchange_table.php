<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExternalExchangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_exchange', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('from_currency_id')->unsigned()->nullable();
            $table->foreign('from_currency_id')->references('id')->on('currencies');
            $table->integer('to_currency_id')->unsigned()->nullable();
            $table->foreign('to_currency_id')->references('id')->on('currencies');
            $table->double('amount')->default(0);  
            $table->double('total_exchange_amount')->default(0);  
            $table->double('exchange_rate_variant')->signed()->default(0)->comment('% : +/- '); 
            $table->double('fee')->default(0)->comment('%');  
            $table->double('base_fee')->default(0)->comment('flat');  
            $table->text('transaction_id')->nullable();  
            $table->double('fee_total')->default(0);  
            $table->double('exchangerate_per')->default(0); 
            $table->double('exchangerate_variant')->default(0); 
            $table->text('response')->nullable();   
            //$table->text('from_response')->nullable();   
            $table->text('to_response')->nullable();   
            $table->enum('type',['fiat','crypto'])->nullable(); 
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
        Schema::dropIfExists('external_exchange');
    }
}
