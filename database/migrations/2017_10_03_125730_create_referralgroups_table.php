<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferralgroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referralgroups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('referral_commission')->unsigned();
            $table->text('level_commission');
            $table->double('min_amount',15,8)->default(0);      
            $table->boolean('active');   
            $table->boolean('is_default');   
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
        Schema::drop('referralgroups');
    }
}
