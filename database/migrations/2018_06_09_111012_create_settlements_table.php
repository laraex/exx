<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('currency_id')->unsigned()->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies');                
            $table->text('to')->nullable(); 
            $table->text('type')->nullable(); 
            $table->double('amount')->default(0);
            $table->enum('status',['queue','process','complete','cancel'])->default('queue');
            $table->text('response')->nullable(); 
            $table->integer('entity_id')->nullable();
            $table->text('entity_name')->nullable();
            $table->enum('mode',['online','offline'])->nullable();
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
        Schema::dropIfExists('settlements');
    }
}
