<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFundtransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fundtransfers', function (Blueprint $table) {
            $table->increments('id');
            $table->double('amount');
            $table->integer('from_account_id')->unsigned();
            $table->foreign('from_account_id')->references('id')->on('usercurrencyaccounts');       
            $table->unsignedBigInteger('debit_transaction_id')->nullable();
            $table->foreign('debit_transaction_id')->references('id')->on('transactions');
            $table->integer('to_account_id')->unsigned();
            $table->foreign('to_account_id')->references('id')->on('usercurrencyaccounts');
            $table->unsignedBigInteger('credit_transaction_id')->nullable();
            $table->foreign('credit_transaction_id')->references('id')->on('transactions');
            $table->double('admin_commission')->nullable();
            $table->text('comments')->nullable();
            $table->tinyInteger('active')->unsigned()->default("1");
            $table->text('transaction_id')->nullable();
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
        Schema::dropIfExists('fundtransfers');
    }
}
