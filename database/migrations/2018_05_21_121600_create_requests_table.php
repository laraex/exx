<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('fromcurrency_id')->unsigned()->nullable();
            $table->foreign('fromcurrency_id')->references('id')->on('currencies');
            $table->integer('tocurrency_id')->unsigned()->nullable();
            $table->foreign('tocurrency_id')->references('id')->on('currencies');
            $table->double('amount',20,8)->default(0);
             $table->double('buy_volume',20,2)->default(0);

            $table->string('send_address')->nullable();
            $table->string('transaction_id')->nullable();
            $table->double('total_amount',16,8)->default(0);

            $table->double('fee',16,8)->default(0);
            $table->double('net_amount',16,8)->default(0);
            $table->enum('request_type',['buy','sell'])->nullable();
            $table->enum('request_status',['Pending','Completed','Canceled','Completed','Awaiting Authorization','Awaiting Approval'])->nullable();
           $table->datetime('request_date')->nullable();
           $table->text('response')->nullable();
           $table->text('request')->nullable();
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
        Schema::dropIfExists('requests');
    }
}
