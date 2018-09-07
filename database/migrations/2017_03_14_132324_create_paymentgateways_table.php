<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentgatewaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paymentgateways', function (Blueprint $table) {
            $table->increments('id');
            $table->string('gatewayname')->unique()->comment('Do not change');
            $table->string('displayname');
            $table->boolean('active');
            $table->integer('currency_id')->unsigned()->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies'); 
            $table->boolean('withdraw')->default('0');
            $table->double('withdraw_commission')->default('0');
            $table->boolean('exchange')->default('0');                        
            $table->text('params');
            $table->text('instructions');
            $table->double('crypto_withdraw_fee')->default('0')->comment('%');
            $table->double('crypto_withdraw_base_fee')->default('0')->comment('flat');
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
        Schema::dropIfExists('paymentgateways');
    }
}
