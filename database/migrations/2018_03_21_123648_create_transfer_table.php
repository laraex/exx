<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->double('amount');
            $table->integer('coin_id')->unsigned();
            $table->foreign('coin_id')->references('id')->on('currencies')->nullable();
            $table->enum('status',['pending','approve','complete','cancel'])->nullable();
            $table->text('response')->nullable();
            $table->text('from_address')->nullable();
            $table->text('to_address')->nullable();
            $table->text('transaction_id')->nullable();
            $table->text('comment')->nullable();
            $table->double('fee',20,8)->default(0)->comment('%');  
            $table->double('base_fee',20,8)->default(0)->comment('flat');  
            $table->double('fee_total',20,8)->default(0); 
            $table->integer('authorised_by')->unsigned()->nullable();
            $table->foreign('authorised_by')->references('id')->on('users');
            $table->datetime('authorised_at')->nullable();
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
        Schema::dropIfExists('transfer');
    }
}
