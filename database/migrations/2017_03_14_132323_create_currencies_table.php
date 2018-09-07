<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image');
            $table->string('coverimage');
            $table->string('name')->comment('Default name.Do not Change');
            $table->string('displayname');
            $table->string('token')->nullable();            
            $table->integer('order')->nullable();
            $table->text('information')->nullable();
            $table->boolean('status'); 
            $table->boolean('is_coin')->default(0); 
            $table->enum('type',['crypto','fiat','primary','token'])->default('fiat'); 
            $table->integer('decimal')->nullable();
            $table->text('symbol')->nullable();
            $table->boolean('coupon_status')->default(0);
            $table->boolean('is_tab')->default(0); 
            $table->integer('withdraw_min_amount');
            $table->integer('withdraw_max_amount');
            $table->boolean('token_status')->default(true);
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
        
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('currencies');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
