<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErc20tokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('erc20token', function (Blueprint $table) {
            $table->increments('id');
            $table->string('token_name');
            $table->string('token_symbol');
            $table->integer('decimal')->default(0);
            $table->text('token_image');
            $table->text('token_contract_address');
            $table->boolean('active')->default('1');
            $table->enum('mode',['testnet','live'])->nullable();
            $table->text('eth_address')->nullable();
            $table->text('eth_passphrase')->nullable();
            $table->text('contract_abi')->nullable();
            $table->double('buy_min_amount')->default(0);  
            $table->double('buy_max_amount')->default(0);
            $table->double('buy_limit_per_user')->default(0);
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
        Schema::dropIfExists('erc20token');
    }
}
