<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_information', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum('status',['employed','unemployed'])->nullable();
            $table->text('title')->nullable();
            $table->text('name')->nullable();
            $table->text('state')->nullable();
            $table->text('district')->nullable();
            $table->text('street')->nullable();
            $table->text('source')->nullable();
            $table->text('net_amount')->nullable();
            $table->text('industry')->nullable();
            $table->integer('country')->nullable()->unsigned();
            $table->foreign('country')->references('id')->on('countries');
            $table->text('city')->nullable();
            $table->text('number')->nullable();
            $table->text('zip')->nullable();
            $table->text('investment')->nullable();
            $table->text('q1')->nullable();
            $table->text('q2')->nullable();
            $table->text('q3')->nullable();
            $table->text('q4')->nullable();
            $table->text('q5')->nullable();
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
        Schema::dropIfExists('user_information');
    }
}
