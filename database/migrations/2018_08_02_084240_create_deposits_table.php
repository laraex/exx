<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('currency_id')->unsigned()->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->integer('paymentgateway_id')->unsigned()->nullable();
            $table->foreign('paymentgateway_id')->references('id')->on('paymentgateways');
            $table->double('amount',50,30);
            $table->double('receive_amount',50,30)->default(0);
            $table->enum('status', ['new','pending','approve','cancel'])->nullable();
            $table->text('transaction_id')->nullable();
            $table->text('request')->nullable();
            $table->text('response')->nullable();
            $table->text('comment')->nullable();
            $table->integer('authorised_by')->unsigned()->nullable();
            $table->foreign('authorised_by')->references('id')->on('users');
            $table->datetime('authorised_at')->nullable();
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
        Schema::dropIfExists('deposits');
    }
}
