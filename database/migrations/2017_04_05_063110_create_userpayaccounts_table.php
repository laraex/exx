<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserpayaccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userpayaccounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('paymentgateways_id')->unsigned();
            $table->foreign('paymentgateways_id')->references('id')->on('paymentgateways');

            $table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies');

            $table->boolean('active')->default("1");
            $table->boolean('current')->nullable();
            $table->string('param1');
            $table->string('param2')->nullable();
            $table->string('param3')->nullable();
            $table->string('param4')->nullable();
            $table->string('param5')->nullable();
            $table->string('param6')->nullable();
            $table->string('param7')->nullable();
            $table->string('param8')->nullable();
            $table->string('btc_label')->nullable();
            $table->string('btc_address')->nullable();
            $table->string('ltc_label')->nullable();
            $table->string('ltc_address')->nullable();
            $table->string('doge_label')->nullable();
            $table->string('doge_address')->nullable();
            $table->string('eth_address')->nullable();
            $table->string('eth_passphrase')->nullable();
            $table->text('bch_label')->nullable();
            $table->text('bch_address')->nullable();
            $table->text('xrp_secret')->nullable();
            $table->text('xrp_address')->nullable();
            $table->string('qtum_label')->nullable();
            $table->string('qtum_address')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('userpayaccounts');
    }
}
