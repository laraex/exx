<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->increments('id');
           $table->unsignedBigInteger('transaction_id')->nullable();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->integer('payaccount_id')->unsigned();
            $table->foreign('payaccount_id')->references('id')->on('userpayaccounts')->onDelete('cascade');
            $table->enum('status',['request','pending','completed','rejected','cancelled'])->nullable();
            $table->double('amount',15,8);
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
             $table->double('commission_per',15,8)->default('0');
              $table->double('commission_total',15,8)->default('0');
            $table->string('param')->nullable();
            $table->string('param1')->nullable();            
            $table->datetime('completed_on')->nullable();
            $table->text('comments_on_complete')->nullable();
            $table->datetime('rejected_on')->nullable();
            $table->text('comments_on_rejected')->nullable();
            $table->datetime('cancelled_on')->nullable();
            $table->integer('autowithdraw')->default('0');
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
        Schema::drop('withdraws');
    }
}
