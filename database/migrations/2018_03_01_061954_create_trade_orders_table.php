<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradeOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum('type',['buy','sell','order'])->nullable();
            $table->double('amount',20,8)->default(0);
            $table->double('quantity',20,8)->default(0);
            $table->integer('from_coin_id')->unsigned()->nullable();
            $table->foreign('from_coin_id')->references('id')->on('currencies');
            $table->integer('to_coin_id')->unsigned()->nullable();
            $table->foreign('to_coin_id')->references('id')->on('currencies');
            $table->enum('status',['pending','partialcomplete','complete','cancel'])->nullable();
            $table->double('total_amount',20,8)->default(0);            
            $table->datetime('cancel_at')->nullable();
            $table->integer('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('trade_orders');
            $table->integer('buy_order_id')->unsigned()->nullable();
            $table->foreign('buy_order_id')->references('id')->on('trade_orders');
            $table->integer('sell_order_id')->unsigned()->nullable();
            $table->foreign('sell_order_id')->references('id')->on('trade_orders');
            $table->integer('ref_id')->unsigned()->nullable();
            $table->foreign('ref_id')->references('id')->on('trade_orders');
            $table->text('parent_id')->nullable();
            $table->datetime('order_at')->nullable();
            
            $table->double('fee',20,8)->default(0)->comment('%');  
            $table->double('base_fee',20,8)->default(0)->comment('flat');  
            $table->double('fee_total',20,8)->default(0);  
            
            $table->text('response')->nullable(); 
            $table->text('cancel_response')->nullable(); 
          
            $table->text('token_hash_id')->nullable(); 

                     
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
        Schema::dropIfExists('trade_orders');
    }
}