<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrencyPairTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_pair', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_currency_id')->unsigned()->nullable();
            $table->foreign('from_currency_id')->references('id')->on('currencies');
            $table->integer('to_currency_id')->unsigned()->nullable();
            $table->foreign('to_currency_id')->references('id')->on('currencies');
            $table->enum('status',['active','inactive'])->default('inactive'); 
            $table->double('min_amount')->default(0);  
            $table->double('max_amount')->default(0);
            $table->double('exchange_rate_variant')->signed()->default(0)->comment('% : +/- '); 
            $table->double('fee')->default(0)->comment('%');  
            $table->double('base_fee')->default(0)->comment('flat');  
            $table->enum('type',['fiat','crypto'])->nullable(); 
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
        Schema::dropIfExists('currency_pair');
    }
}
