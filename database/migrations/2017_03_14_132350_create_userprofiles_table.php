<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserprofilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userprofiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('usergroup_id')->unsigned()->nullable();
            $table->foreign('usergroup_id')->references('id')->on('usergroups'); 
            $table->boolean('active')->default('1'); 
            $table->string('transaction_password')->nullable();    
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('mobile')->nullable();
            $table->integer('country')->nullable()->unsigned();
            $table->foreign('country')->references('id')->on('countries');
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('ssn')->nullable();
            $table->string('profile_avatar')->nullable();
            $table->string('kyc_doc')->nullable();
            $table->boolean('email_verified')->default('0');
            $table->uuid('email_verification_code')->nullable();
            $table->boolean('mobile_verified')->default('0');
            $table->uuid('mobile_verification_code')->nullable();
            $table->boolean('kyc_verified')->default('0');
          /*  $table->integer('referral_group_id')->nullable()->unsigned();*/
            $table->text('btc_address')->nullable();
            $table->text('ltc_address')->nullable();   
            $table->text('eth_address')->nullable(); 
            $table->boolean('passport')->nullable();
            $table->string('passport_no')->nullable();
            $table->date('passport_expiry')->nullable();
            $table->text('passport_data')->nullable();
            $table->text('passport_attachment')->nullable();
            $table->boolean('passport_verified')->default('0');
            $table->boolean('id_card')->nullable();
            $table->string('id_card_no')->nullable();
            $table->date('id_card_expiry')->nullable();
            $table->text('id_card_data')->nullable();
            $table->text('id_card_attachment')->nullable();
            $table->boolean('id_card_verified')->default('0');
            $table->boolean('driving_license')->nullable();
            $table->string('driving_license_no')->nullable();
            $table->date('driving_license_expiry')->nullable();
            $table->text('driving_license_data')->nullable();
            $table->text('driving_license_attachment')->nullable();
            $table->boolean('driving_license_verified')->default('0');
            $table->boolean('photo_id')->nullable();
            $table->string('photo_id_no')->nullable();
            $table->date('photo_id_expiry')->nullable();
            $table->text('photo_id_data')->nullable();
            $table->text('photo_id_attachment')->nullable();
            $table->boolean('photo_id_verified')->default('0');
            $table->boolean('bank')->nullable();           
            $table->text('bank_data')->nullable();
            $table->text('bank_attachment')->nullable();
            $table->boolean('bank_verified')->default('0');
            $table->boolean('kyc_approved')->default('0');
            $table->boolean('kyc_verified_status')->default('0');
            $table->string('fav_pair')->nullable();
             $table->string('zipcode')->nullable();
            $table->date('dateofbirth')->nullable();
            $table->enum('gender',['male','female'])->nullable(); 
            $table->integer('nationality_id')->nullable()->unsigned();
            $table->foreign('nationality_id')->references('id')->on('nationality');
            $table->text('occupation')->nullable();
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
        Schema::dropIfExists('userprofiles');
    }
}
