<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('transactions', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('currency_id')->unsigned()->nullable();
			$table->foreign('currency_id')->references('id')->on('currencies');
			$table->integer('account_id')->unsigned()->nullable();
			$table->foreign('account_id')->references('id')->on('usercurrencyaccounts')->onDelete('cascade'); //have to remove
			$table->double('amount', 50, 30);
			$table->enum('type', ['credit', 'debit']);
			$table->enum('status', ['pending', 'approve', 'cancel'])->nullable();
			$table->string('action')->nullable();		
			$table->integer('accounting_code_id')->unsigned()->nullable();
			$table->foreign('accounting_code_id')->references('id')->on('accountingcodes');
			$table->text('request')->nullable();
			$table->text('response')->nullable();
			$table->text('comment')->nullable();
			$table->integer('entity_id')->nullable();
			$table->text('entity_name')->nullable();
			$table->text('blockchain_transaction_id')->nullable();
			$table->text('blockchain_data')->nullable();
			$table->double('balance_before', 50, 30)->default(0);
			$table->double('balance_after', 50, 30)->default(0);
			$table->timestamps();
			$table->softDeletes();
		
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::disableForeignKeyConstraints();
		Schema::dropIfExists('transactions');
	}
}
