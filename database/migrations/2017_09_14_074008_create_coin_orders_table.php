<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coin_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_user_id')->unsigned();
            $table->foreign('from_user_id')->references('id')->on('users');
            $table->integer('to_user_id')->nullable();                     
            $table->enum('type',['buy','sell','order'])->nullable();
            $table->double('amount');
            $table->double('order_amount');
            $table->double('receive_amount')->default(0);
            $table->integer('request_coin_id')->unsigned();
            $table->foreign('request_coin_id')->references('id')->on('currencies')->nullable();
            $table->integer('from_currency')->unsigned();
            $table->foreign('from_currency')->references('id')->on('currencies')->nullable();
            $table->enum('status',['pending','approve','cancel','wallet'])->nullable();
            $table->enum('mode',['offline','online'])->nullable();
            $table->datetime('approve_at')->nullable();
            $table->datetime('cancel_at')->nullable();
            $table->text('comments_approve')->nullable();
            $table->text('comments_cancel')->nullable();
            $table->text('comments')->nullable();
            $table->enum('process_via',['user','admin','auto'])->nullable();           
            $table->text('request')->nullable();
            $table->text('response')->nullable();
            $table->double('commission')->nullable();
            $table->double('to_amount')->nullable();            
            $table->string('transaction_id')->unique();
            $table->text('bitcoin_hash_id')->nullable();
            $table->text('comments_pending')->nullable();        
            $table->integer('coin_orders_ref_id')->nullable();
            $table->text('btc_hash_id')->nullable(); 
            $table->text('ltc_hash_id')->nullable();   
            $table->text('eth_hash_id')->nullable();
            $table->text('user_comments')->nullable();
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
        Schema::dropIfExists('coin_orders');
    }
}
